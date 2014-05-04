<?php

require_once dirname(__FILE__) . '/config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');
$modx->getService('error','error.modError', '', '');

/** @var Scheduler $scheduler */
$path = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path') . 'components/scheduler/');
$scheduler = $modx->getService('scheduler', 'Scheduler', $path . 'model/scheduler/');

$task = $scheduler->getTask('core', 'berts_test_mail');
if ($task instanceof sTask) {
    $task->schedule('+1 minute', array(
        'client' => 1,
        'emailTpl' => 'emailChunkName',
        'emailSubject' => 'The new subject',
    ));
    $modx->log(modX::LOG_LEVEL_INFO, '[Scheduler] Task scheduled!');
    return true;
}

$modx->log(modX::LOG_LEVEL_ERROR, '[Scheduler] No task found!');
return false;