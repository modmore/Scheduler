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
$table = $modx->getTableName('sTaskRun');
foreach ($modx->getIterator('sTaskRun', $c) as $taskRun) {
    // Atomic status update to prevent race condition
    // If another process already took this task, affected = 0
    $taskRunId = $taskRun->get('id');
    $stmt = $modx->prepare("UPDATE {$table} SET status = :executing WHERE id = :id AND status = :scheduled");
    $stmt->execute([
        ':executing' => sTaskRun::STATUS_EXECUTING,
        ':id' => $taskRunId,
        ':scheduled' => sTaskRun::STATUS_SCHEDULED
    ]);

    if ($stmt->rowCount() === 0) {
        // Task already taken by another process, skip
        $modx->log(modX::LOG_LEVEL_DEBUG, "[Scheduler] Task run {$taskRunId} already taken by another process, skipping");
        continue;
    }

    // Reload object with updated status
    $taskRun = $modx->getObject('sTaskRun', $taskRunId);
    $task = $taskRun->getOne('Task');

    if ($task instanceof sTask) {
        $startTime = microtime(true);
        $task->run($taskRun, true); // true = status is already EXECUTING
        $processingTime = microtime(true) - $startTime;
        $taskRun->set('processing_time', $processingTime);
        $taskRun->save();
    }

    // Memory cleanup after each task
    unset($task, $taskRun);
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
