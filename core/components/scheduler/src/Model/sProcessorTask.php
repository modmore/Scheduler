<?php

namespace Scheduler\Model;

use MODX\Revolution\Processors\ProcessorResponse;
use MODX\Revolution\Processors\ProcessorResponseError;

/**
 * Class sProcessorTask
 */
class sProcessorTask extends sTask
{
    /**
     * @param sTaskRun $run
     * @return mixed
     */
    public function _run($run)
    {
        $action = $this->get('content');
        $path = $this->getOption('core_path') . 'model/modx/processors/';
        $data = [
            'task' => $this,
            'run' => $run,
        ];
        $runData = $run->get('data');
        if (is_array($runData)) {
            $data = array_merge($runData, $data);
        }

        $namespace = $this->_getNamespace();
        if ($namespace && $namespace->name != 'core') {
            $path = $namespace->getCorePath() . 'processors/';
        }

        $this->xpdo->error->reset();

        /** @var ProcessorResponse $response */
        $response = $this->xpdo->runProcessor($action, $data, [
            'processors_path' => $path,
        ]);
        if ($response->isError()) {
            $errors = $response->getFieldErrors();
            /** @var ProcessorResponseError $error */
            foreach ($errors as $error) {
                $run->addError($error->field, ['message' => $error->error]);
            }
        }
        return $response->getMessage();
    }
}
