<?php

class SchedulerRescheduleTaskRunProcessor extends modObjectDuplicateProcessor {
    public $classKey = 'sTaskRun';
    public $objectType = 'scheduler.staskrun';
    public $languageTopics = array('scheduler:default');

    /** @var sTaskRun $object */
    public $object;
    /** @var sTaskRun $newObject */
    public $newObject;

    public function beforeSave() {

        $this->newObject->set('status', sTaskRun::STATUS_SCHEDULED);
        $this->newObject->set('executedon', null);
        $this->newObject->set('errors', null);
        $this->newObject->set('message', null);

        // get timing or create one
        $timing = $this->getProperty('timing_new', 0);
        if(empty($timing)) {

            $timingNr = $this->getProperty('timing_number', 1);
            $timingInterval = $this->getProperty('timing_interval', 'minute').(($timingNr != 1) ? 's' : ''); // to make it: minutes, hours, months.. etc.
            $timing = strtotime('+'.$timingNr.' '.$timingInterval);
        }
        if(empty($timing)) { $this->addFieldError('timing', $this->modx->lexicon('scheduler.error.no-timing')); }
        $this->newObject->setTiming($timing, false);

        return parent::beforeSave();
    }
}

return 'SchedulerRescheduleTaskRunProcessor';