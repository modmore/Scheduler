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
        $data = [
            'task' => &$this,
            'run' => &$run,
        ];
        $runData = $run->get('data');
        if (is_array($runData)) {
            $data = array_merge($runData, $data);
        }

        $options = [];

        // MODX 3: If action contains namespace (e.g. MiniShop3\Processors\...),
        // processor is loaded via autoload and processors_path is not needed
        if (!$this->isNamespacedProcessor($action)) {
            // Legacy processors require path specification
            $options['processors_path'] = $this->getProcessorsPath();
        }

        /** @var \modProcessorResponse $response */
        $response = $this->xpdo->runProcessor($action, $data, $options);

        if ($response->isError()) {
            $errors = $response->getFieldErrors();
            /** @var \modProcessorResponseError $error */
            foreach ($errors as $error) {
                $run->addError($error->field, ['message' => $error->error]);
            }
        }

        return $response->getMessage();
    }

    /**
     * Check if action is a namespace-based class (MODX 3 style)
     *
     * @param string $action
     * @return bool
     */
    protected function isNamespacedProcessor(string $action): bool
    {
        // Namespaced processors contain backslashes
        return strpos($action, '\\') !== false;
    }

    /**
     * Determine path to legacy processors
     *
     * @return string
     */
    protected function getProcessorsPath(): string
    {
        $namespace = $this->_getNamespace();

        if ($namespace && $namespace->name !== 'core') {
            $corePath = $namespace->getCorePath();

            // MODX 3 components: check src/Processors/ first
            $modx3Path = $corePath . 'src/Processors/';
            if (is_dir($modx3Path)) {
                return $modx3Path;
            }

            // Legacy path for components
            return $corePath . 'processors/';
        }

        // Core MODX 3 processors
        $modx3CorePath = $this->xpdo->getOption('core_path') . 'src/Revolution/Processors/';
        if (is_dir($modx3CorePath)) {
            return $modx3CorePath;
        }

        // Legacy MODX 2 path
        return $this->xpdo->getOption('core_path') . 'model/modx/processors/';
    }
}
