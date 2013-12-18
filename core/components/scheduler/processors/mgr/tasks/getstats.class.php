<?php

/**
 * Class getTaskStatsProcessor
 */
class getTaskStatsProcessor extends modProcessor {

    /**
     * Fetches the stats
     *
     * @return mixed
     */
    public function process()
    {
        $queued = $this->modx->getCount('sTaskRun', array('status' => sTaskRun::STATUS_SCHEDULED));
        $pastdue = $this->modx->getCount('sTaskRun', array('status' => sTaskRun::STATUS_SCHEDULED, 'AND:timing:<' => time()));
        $running = $this->modx->getCount('sTaskRun', array('status' => sTaskRun::STATUS_EXECUTING));
        $completed = $this->modx->getCount('sTaskRun', array('status' => sTaskRun::STATUS_SUCCESS, 'OR:status:=' => sTaskRun::STATUS_FAILURE));
        $stats = array(
            'scheduler-upcoming-queued' => (string)$queued,
            'scheduler-upcoming-pastdue' => (string)$pastdue,
            'scheduler-upcoming-running' => (string)$running,
            'scheduler-upcoming-completed' => (string)$completed,
        );
        return $this->modx->toJSON(array('success' => true, 'stats' => $stats));
    }
}

return 'getTaskStatsProcessor';
