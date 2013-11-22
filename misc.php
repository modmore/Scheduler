<?php
require_once dirname(__FILE__) . '/config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');
$modx->getService('error','error.modError', '', '');

$path = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path') . 'components/scheduler/');
/**
 * @var Scheduler $scheduler
 */
$scheduler = $modx->getService('scheduler', 'Scheduler', $path . 'model/scheduler/');

if (!($scheduler instanceof Scheduler)) {
    die('Oops, could not get Scheduler class.');
}

$scheduler->setTask('scheduler', 'sometask', '+342 minutes', dirname(__FILE__).'/randomtask.php', array(
        'Variable1' => 'Foo',
        'Variable2' => 'Bar',
    ), 'Final random task to test setTask and running it.');
