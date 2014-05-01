<?php

class SchedulerRemoveTaskProcessor extends modObjectRemoveProcessor {
    public $classKey = 'sTask';
    public $objectType = 'scheduler.stask';
    public $languageTopics = array('scheduler:default');
}

return 'SchedulerRemoveTaskProcessor';