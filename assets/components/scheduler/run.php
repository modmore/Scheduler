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
$modx->getService('error','error.modError');
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
        $startTime = microtime(true);
        $task->run($taskRun);
        $processingTime = microtime(true) - $startTime;
        $taskRun->set('processing_time', $processingTime);
        $taskRun->save();
    }
}

$modx->log(modX::LOG_LEVEL_INFO, '[Scheduler] Done!');

// Every 30 minutes, run the cleanup for old tasks
if (date('i') % 30 === 0) {
    $deleteAfter = $modx->getOption('scheduler.delete_tasks_after', null, '', true);
    $deleteAfter = !empty($deleteAfter) ? strtotime($deleteAfter) : null;
    if ($deleteAfter) {
        $count = $modx->removeCollection(sTaskRun::class, [
            'status:IN' => [sTaskRun::STATUS_FAILURE, sTaskRun::STATUS_SUCCESS],
            'executedon:<' => $deleteAfter
        ]);
        $modx->log(modX::LOG_LEVEL_INFO, '[Scheduler] Cleaned up ' . $count . ' task runs older than ' . date('Y-m-d H:i:s', $deleteAfter));
    }
}
