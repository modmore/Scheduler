<?php

class SchedulerCreateTaskRunProcessor extends modObjectCreateProcessor {
    public $classKey = 'sTaskRun';
    public $objectType = 'scheduler.staskrun';
    public $languageTopics = array('scheduler:default');

    /** @var sTaskRun $object */
    public $object;

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

    public function beforeSave() {

        // get timing or create one
        $timing = $this->getProperty('timing', 0);
        if(empty($timing)) {

            $timingNr = $this->getProperty('timing_number', 1);
            $timingInterval = $this->getProperty('timing_interval', 'minute').(($timingNr != 1) ? 's' : ''); // to make it: minutes, hours, months.. etc.
            $timing = strtotime('+'.$timingNr.' '.$timingInterval);
        }
        if(empty($timing)) { $this->addFieldError('timing', $this->modx->lexicon('scheduler.error.no-timing')); }
        $this->object->setTiming($timing, false);

        return parent::beforeSave();
    }
}

return 'SchedulerCreateTaskRunProcessor';