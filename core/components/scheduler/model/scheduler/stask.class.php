<?php
/**
 * Class sTask
 *
 * @package Scheduler
 */
class sTask extends xPDOSimpleObject
{
    /**
     * @param int|string $when
     * @param array $data
     * @return false|sTask
     */
    public function schedule($when, array $data = array()) {
        if (strpos($when, '+') !== false) {
            $when = strtotime($when);
        }

        /** @var sTaskRun $run */
        $run = $this->xpdo->newObject('sTaskRun');
        $run->fromArray(array(
            'task' => $this->get('id'),
            'timing' => $when,
            'data' => $data,
        ));

        if ($run->save()) {
            return $this;
        }
        return false;
    }

    /**
     * @param sTaskRun $run
     * @return sTask $this
     */
    public function run($run)
    {
        // Set status to executing (and save) so other triggers don't also run this one
        $run->set('status', sTaskRun::STATUS_EXECUTING);
        $run->save();

        // Run the task
        $return = $this->_run($run);

        // All done! Update status, completed date and save.
        $run->set('status', ($run->hasErrors()) ? sTaskRun::STATUS_FAILURE : sTaskRun::STATUS_SUCCESS);
        $run->set('message', $return);
        $run->set('executedon', time());
        $run->save();

        return $this;
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

    /**
     * @param sTaskRun $run
     * @return mixed
     */
    public function _run(&$run)
    {
        $snippet = $this->get('content');
        $data['task'] =& $this;
        $data['run'] =& $run;

        // Check if the snippet exists before running it.
        // This may fail with OnElementNotFound snippets in 2.3
        if ($this->xpdo->getCount('modSnippet', array('name' => $snippet)) < 1) {
            $run->addError('snippet_not_found', array(
                'snippet' => $snippet
            ));
            return false;
        }
        return $this->xpdo->runSnippet($snippet, $data);
    }
}
