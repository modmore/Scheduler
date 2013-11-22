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
        $queued = $this->modx->getCount('sTask', array('status' => sTask::STATUS_PENDING));
        $pastdue = $this->modx->getCount('sTask', array('status' => sTask::STATUS_PENDING, 'AND:executeon:<' => time()));
        $completed = $this->modx->getCount('sTask', array('status:!=' => sTask::STATUS_PENDING));
        $stats = array(
            'scheduler-upcoming-queued' => $queued,
            'scheduler-upcoming-pastdue' => $pastdue,
            'scheduler-upcoming-completed' => $completed,
        );
        return $this->modx->toJSON(array('success' => true, 'stats' => $stats));
    }
}

return 'getTaskStatsProcessor';
