<?php
/**
 * Class sTask
 *
 * @package Scheduler
 */
class sTask extends xPDOSimpleObject
{
    const STATUS_PENDING = 1;
    const STATUS_EXECUTING = 2;
    const STATUS_SUCCESS = 3;
    const STATUS_FAILURE = 0;

    const RUN_FILE = 'file';
    const RUN_SNIPPET = 'snippet';

    /**
     * @return sTask $this
     */
    public function run()
    {
        // Set status to executing (and save) so other triggers don't also run this one
        $this->set('status', sTask::STATUS_EXECUTING);
        $this->save();

        // Get some stuff
        $type = $this->get('type');
        $content = $this->get('content');
        $data = $this->get('data');
        $return = '';

        // Based on the type, run the task in the expected way
        switch ($type) {
            case self::RUN_FILE:
                $return = $this->_runFile($content, $data);
                break;

            case self::RUN_SNIPPET:
                $return = $this->_runSnippet($content, $data);
                break;
        }

        // All done! Update status, completed date and save.
        $this->set('status', ($this->hasErrors()) ? sTask::STATUS_FAILURE : sTask::STATUS_SUCCESS);
        $this->set('returned', $return);
        $this->set('completedon', time());
        $this->save();

        // Return itself for possible chaining. Idk what chaining, but hey.
        return $this;
    }

    /**
     * Adds an error to the error stack and updates the status if necessary
     *
     * @param string $type
     * @param array $details
     */
    public function addError($type, array $details = array())
    {
        $errors = $this->get('errors');
        if (!is_array($errors) || empty($errors)) $errors = array();
        $details['timestamp'] = microtime(true);

        $errors[] = array_merge(array(
            'type' => $type,
            'timestamp' => microtime(true),
        ), $details);

        $this->set('errors', $errors);
        $this->set('status', self::STATUS_FAILURE);
    }

    /**
     * Check if this task has any errors.
     * 
     * @return bool
     */
    public function hasErrors() {
        $errors = $this->get('errors');
        if (is_array($errors) && !empty($errors)) return true;
        return false;
    }

    /**
     * Runs the file for this task.
     *
     * @param $content
     * @param array $data
     * @return bool|mixed|null
     */
    public function _runFile($content, array $data = array())
    {
        // Get some common alternatives; prepending the base and core paths to specified directory.
        $fileBasePath = $this->xpdo->getOption('base_path') . $content;
        $fileCorePath = $this->xpdo->getOption('core_path') . $content;

        // Get path from the namespace
        $fileNamespacePath = false;
        $namespace = $this->_getNamespace();
        if ($namespace) {
            $fileNamespacePath = $namespace->getCorePath() . $content;
        }

        // The $file placeholder will hold the eventual file path as determined by priority
        $file = false;

        // Run through different ways the file could be specified in priority:
        // 1. Absolute specification
        // 2. Relative to the namespace core path
        // 3. Relative to the MODX root path
        // 4. Relative to the MODX core path
        if (file_exists($content)) {
            $file = $content;
        } elseif ($namespace && file_exists($fileNamespacePath)) {
            $file = $fileNamespacePath;
        } elseif (file_exists($fileBasePath)) {
            $file = $fileBasePath;
        } elseif (file_exists($fileCorePath)) {
            $file = $fileCorePath;
        }

        // $result will hold the eventual response from the task. Null for now.
        $result = null;

        // If we have determined a valid file path, we run it
        if (!empty($file)) {
            // Wrapping in try/catch block in an attempt to catch exceptions before they break stuff entirely
            try {
                // Make some stuff available for convenience
                $task =& $this;
                $modx =& $this->xpdo;
                $scriptProperties = $data;

                // Include the file. Sorta ugly but open to better approaches.
                $result = include $file;
            } catch (Exception $e) {
                $this->addError('exception', array(
                    'error' => $e->getMessage(),
                    'file' => $file,
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ));
            }
        } else {
            $this->addError('file_not_found', array(
                'file' => $content,
                'file_namespace_path' => $fileNamespacePath,
                'file_base_path' => $fileBasePath,
                'file_core_path' => $fileCorePath,
            ));
        }


        if ($result !== null) {
            return $result;
        }
        return false;
    }

    /**
     * Runs the snippet assigned to this task.
     *
     * @param string $content
     * @param array $data
     * @return mixed
     */
    public function _runSnippet($content, array $data = array())
    {
        // Check if the snippet exists before running it.
        // This may fail with OnElementNotFound snippets in 2.3
        if ($this->xpdo->getCount('modSnippet', array('name' => $content)) < 1) {
            $this->addError('snippet_not_found', array(
                'snippet' => $content
            ));
            return false;
        }
        return $this->xpdo->runSnippet($content, $data);
    }

    /**
     * Gets the namespace object for the task.
     *
     * @return null|modNamespace
     */
    public function _getNamespace()
    {
        $ns = $this->get('namespace');
        if (!empty($ns)) {
            $namespace = $this->xpdo->getObject('modNamespace', $ns);
            if ($namespace instanceof modNamespace) {
                return $namespace;
            }
        }
        return null;
    }
}
