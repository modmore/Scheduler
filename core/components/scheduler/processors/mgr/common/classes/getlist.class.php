<?php

class SchedulerClassKeysGetListProcessor extends modProcessor {

    protected $coreKeys = array('sFileTask','sSnippetTask','sProcessorTask');

    public function process() {

        $list = array();
        foreach($this->coreKeys as $classKey) {
            $list[] = array(
                'key' => $classKey,
                'value' => $this->modx->lexicon('scheduler.class.'.$classKey),
            );
        }

        return $this->outputArray($list, count($list));
    }
}

return 'SchedulerClassKeysGetListProcessor';