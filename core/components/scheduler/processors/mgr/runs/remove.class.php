<?php

class SchedulerRemoveTaskProcessor extends modObjectRemoveProcessor {
    public $classKey = 'sTaskRun';
    public $objectType = 'scheduler.staskrun';
    public $languageTopics = array('scheduler:default');
}

return 'SchedulerRemoveTaskProcessor';