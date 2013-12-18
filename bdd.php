<?php
require_once dirname(__FILE__) . '/config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');
$modx->getService('error','error.modError', '', '');

$path = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path') . 'components/scheduler/');
/** @var Scheduler $scheduler */
$scheduler = $modx->getService('scheduler', 'Scheduler', $path . 'model/scheduler/');


$task = $scheduler->getTask('scheduler', 'random');
if ($task instanceof sTask) {
    $task->schedule('+10 minutes', array(
        'client' => 15
    ));
}
var_dump('no task');

