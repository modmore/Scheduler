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

        /** @var sTaskRun $run */
        $run = $this->xpdo->newObject('sTaskRun');
        $run->fromArray(array(
            'task' => $this->get('id'),
            'data' => $data,
        ));
        $run->setTiming($when);

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
    protected function _run(&$run) {

        /* This method should be abstract, but because of using xPDO::loadClass() in the main model, it cannot handle it */

        $run->addError('stask_direct_run_failure', array(
            'message' => 'Not allowed to run the sTask::_run() method directly!',
        ));
        return false;
    }
}
