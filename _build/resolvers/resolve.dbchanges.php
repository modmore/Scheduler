<?php
/**
 * Resolver for database schema changes (upgrades)
 * Supports both MODX 2.x and MODX 3.x
 *
 * @var xPDO|modX $modx
 * @var array $options
 */
$modx =& $object->xpdo;

// Detect MODX version for proper constant usage
$isModx3 = class_exists('MODX\Revolution\modX');

if ($isModx3) {
    $logLevelInfo = \xPDO\xPDO::LOG_LEVEL_INFO;
    $actionUpgrade = \xPDO\Transport\xPDOTransport::ACTION_UPGRADE;
    $packageAction = \xPDO\Transport\xPDOTransport::PACKAGE_ACTION;
} else {
    $logLevelInfo = xPDO::LOG_LEVEL_INFO;
    $actionUpgrade = xPDOTransport::ACTION_UPGRADE;
    $packageAction = xPDOTransport::PACKAGE_ACTION;
}

switch ($options[$packageAction]) {
    case $actionUpgrade:

        $modx->log($logLevelInfo, 'Applying database schema changes...');
        $modelPath = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path') . 'components/scheduler/') . 'model/';
        $modx->addPackage('scheduler', $modelPath);

        $manager = $modx->getManager();

        // Suppress schema change logging
        $oldLogLevel = $modx->getLogLevel();
        $modx->setLogLevel(0);

        // 2021-02-15 - add field/index for sTaskRun->task_key
        $manager->addField('sTaskRun', 'task_key', ['after' => 'data']);
        $manager->addIndex('sTaskRun', 'task_key');

        // 2021-02-20 - add indexes for better performance
        $manager->addIndex('sTask', 'namespace');
        $manager->addIndex('sTask', 'reference');
        $manager->addIndex('sTaskRun', 'status');
        $manager->addIndex('sTaskRun', 'task');
        $manager->addIndex('sTaskRun', 'timing');
        $manager->addIndex('sTaskRun', 'executedon');
        $manager->addField('sTaskRun', 'processing_time', ['after' => 'executedon']);
        $manager->addIndex('sTaskRun', 'processing_time');

        // 1.8 - Retry logic fields
        $manager->addField('sTask', 'max_retries', ['after' => 'description']);
        $manager->addField('sTask', 'retry_delay', ['after' => 'max_retries']);
        $manager->addField('sTaskRun', 'retry_count', ['after' => 'task_key']);

        // 2024-12-01 - Composite index for optimal task selection
        $manager->addIndex('sTaskRun', 'status_timing');

        // Restore logging
        $modx->setLogLevel($oldLogLevel);

        break;
}

return true;
