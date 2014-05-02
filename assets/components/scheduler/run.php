<?php
/**
 * Scheduler
 *
 * Copyright 2013 by Mark Hamstra <mark@modmore.com>
 * 
 * @package scheduler
 * @var modX $modx
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('scheduler.core_path',null,$modx->getOption('core_path').'components/scheduler/');
require_once $corePath.'model/scheduler/scheduler.class.php';
$scheduler = new Scheduler($modx);

$limit = (integer) $modx->getOption('scheduler.tasks_per_run', null, 1);

/**
 * Get the tasks we need to run right now.
 */
$c = $modx->newQuery('sTaskRun');
$c->where(array(
    'status' => sTaskRun::STATUS_SCHEDULED,
    'AND:timing:<=' => time(),
));
$c->sortby('timing ASC, id', 'ASC');
$c->limit($limit);

/**
 * @var sTaskRun $taskRun
 */
foreach ($modx->getIterator('sTaskRun', $c) as $taskRun) {
    $task = $taskRun->getOne('Task');
    if (!empty($task) && is_object($task) && $task instanceof sTask) {
        $task->run($taskRun);
    }
}

$modx->log(modX::LOG_LEVEL_INFO, '[Scheduler] Done!');
