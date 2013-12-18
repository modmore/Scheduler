<?php
/**
 * Class sFileTask
 */
class sFileTask extends sTask
{
    /**
     * @param sTaskRun $run
     * @return mixed
     */
    public function _run(&$run)
    {
        $content = $this->get('content');

        // Get some common file alternatives; prepending the base and core paths to specified directory.
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
                $scriptProperties = $run->get('data');

                // Include the file. Sorta ugly but open to better approaches.
                $result = include $file;
            } catch (Exception $e) {
                $run->addError('exception', array(
                    'error' => $e->getMessage(),
                    'file' => $file,
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ));
            }
        } else {
            $run->addError('file_not_found', array(
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
}
