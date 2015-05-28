<?php
/**
 * Class sProcessorTask
 */
class sProcessorTask extends sTask
{
    /**
     * @param sTaskRun $run
     * @return mixed
     */
    public function _run(&$run)
    {
        $action = $this->get('content');
        $path = $this->getOption('core_path') . 'model/modx/processors/';
        $data = array (
            'task' => &$this,
            'run' => &$run,
        );
        $runData = $run->get('data');
        if (is_array($runData)) {
            $data = array_merge($runData, $data);
        }

        $namespace = $this->_getNamespace();
        if ($namespace && $namespace->name != 'core') {
            $path = $namespace->getCorePath() . 'processors/';
        }

        /** @var modProcessorResponse $response */
        $response = $this->xpdo->runProcessor($action, $data, array(
            'processors_path' => $path,
        ));
        if ($response->isError()) {
            $errors = $response->getFieldErrors();
            /** @var modProcessorResponseError $error */
            foreach ($errors as $error) {
                $run->addError($error->field, array('message' => $error->error));
            }
        }
        return $response->getMessage();
    }
}
