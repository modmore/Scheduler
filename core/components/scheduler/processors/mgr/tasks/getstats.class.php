<?php

/**
 * Class getTaskStatsProcessor
 */
class getTaskStatsProcessor extends modProcessor
{
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
        $stats = [
            'scheduler-upcoming-queued' => number_format($queued),
            'scheduler-upcoming-pastdue' => number_format($pastdue),
            'scheduler-upcoming-running' => number_format($running),
            'scheduler-upcoming-completed' => number_format($completed),
        ];
        return $this->modx->toJSON(['success' => true, 'stats' => $stats]);
    }
}

return 'getTaskStatsProcessor';
