<?php

class SchedulerTaskRunMultipleListProcessor extends modProcessor
{

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$method = $this->getProperty('method', false)) {
            return $this->failure();
        }
        $ids = json_decode($this->getProperty('ids'), true);
        if (empty($ids)) {
            return $this->success();
        }

        /** @var Scheduler $scheduler */
        $path = $this->modx->getOption(
            'scheduler.core_path',
            null,
            $this->modx->getOption('core_path') . 'components/scheduler/'
        );
        $scheduler = $this->modx->getService('scheduler', 'Scheduler', $path . 'model/scheduler/');

        foreach ($ids as $id) {
            $this->modx->error->reset();
            $processorsPath = !empty($scheduler->config['processorsPath'])
                ? $scheduler->config['processorsPath']
                : MODX_CORE_PATH . 'components/scheduler/processors/';

            /** @var modProcessorResponse $response */
            $response = $this->modx->runProcessor('mgr/runs/' . $method, ['id' => $id], [
                'processors_path' => $processorsPath,
            ]);
            if ($response->isError()) {
                return $response->getResponse();
            }
        }

        return $this->success();
    }

}

return 'SchedulerTaskRunMultipleListProcessor';
