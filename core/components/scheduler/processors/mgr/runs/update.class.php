<?php

class SchedulerUpdateTaskRunProcessor extends modObjectUpdateProcessor {
    public $classKey = 'sTaskRun';
    public $objectType = 'scheduler.staskrun';
    public $languageTopics = array('scheduler:default');

    public function beforeSet() {

        $data = array();
        $dataJson = $this->getProperty('data', '');
        if(!empty($dataJson)) {
            $dataArray = $this->modx->fromJSON($dataJson);
            foreach($dataArray as $entry) {
                $data[$entry['key']] = $entry['value'];
            }
        }
        $this->setProperty('data', ((!empty($data)) ? $data : null));

        return parent::beforeSet();
    }
}

return 'SchedulerUpdateTaskRunProcessor';