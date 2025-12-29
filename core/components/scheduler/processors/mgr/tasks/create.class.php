<?php

class SchedulerCreateTaskProcessor extends modObjectCreateProcessor {
    public $classKey = 'sTask';
    public $objectType = 'scheduler.stask';
    public $languageTopics = array('scheduler:default');

    public function beforeSet() {

        $content = '';
        $classKey = $this->getProperty('class_key');
        switch($classKey) {
            case 'sSnippetTask':
                $content = $this->getProperty('snippet-content');
                if(empty($content)) {
                    $this->addFieldError('snippet-content', $this->modx->lexicon('scheduler.error.no-snippet-content'));
                    return false;
                }
            break;
            case 'sProcessorTask':
                $content = $this->getProperty('processor-content');
                if(empty($content)) {
                    $this->addFieldError('processor-content', $this->modx->lexicon('scheduler.error.no-processor-content'));
                    return false;
                }
            break;
            case 'sFileTask':
            default:
                $content = $this->getProperty('file-content');
                if(empty($content)) {
                    $this->addFieldError('file-content', $this->modx->lexicon('scheduler.error.no-file-content'));
                    return false;
                }
            break;
        }

        $this->setProperty('content', $content);

        // Validate recurring task settings
        $recurring = (bool) $this->getProperty('recurring');
        if ($recurring) {
            $interval = $this->getProperty('interval');
            if (empty($interval)) {
                $this->addFieldError('interval', $this->modx->lexicon('scheduler.error.no-interval'));
                return false;
            }
            $nextTime = strtotime($interval);
            if ($nextTime === false || $nextTime <= time()) {
                $this->addFieldError('interval', $this->modx->lexicon('scheduler.error.invalid-interval'));
                return false;
            }
        }

        return parent::beforeSet();
    }
}

return 'SchedulerCreateTaskProcessor';