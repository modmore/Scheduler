<?php
/**
 * Resolver for creating/removing database tables
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
    $actionInstall = \xPDO\Transport\xPDOTransport::ACTION_INSTALL;
    $actionUpgrade = \xPDO\Transport\xPDOTransport::ACTION_UPGRADE;
    $actionUninstall = \xPDO\Transport\xPDOTransport::ACTION_UNINSTALL;
    $packageAction = \xPDO\Transport\xPDOTransport::PACKAGE_ACTION;
} else {
    $logLevelInfo = xPDO::LOG_LEVEL_INFO;
    $actionInstall = xPDOTransport::ACTION_INSTALL;
    $actionUpgrade = xPDOTransport::ACTION_UPGRADE;
    $actionUninstall = xPDOTransport::ACTION_UNINSTALL;
    $packageAction = xPDOTransport::PACKAGE_ACTION;
}

switch ($options[$packageAction]) {
    case $actionInstall:
    case $actionUpgrade:

        $modx->log($logLevelInfo, 'Creating database tables...');
        $modelPath = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path') . 'components/scheduler/') . 'model/';
        $modx->addPackage('scheduler', $modelPath);

        $manager = $modx->getManager();

        // Suppress table creation logging
        $oldLogLevel = $modx->getLogLevel();
        $modx->setLogLevel(0);

        $manager->createObjectContainer('sTask');
        $manager->createObjectContainer('sTaskRun');

        // Restore logging
        $modx->setLogLevel($oldLogLevel);

        break;

    case $actionUninstall:

        $modx->log($logLevelInfo, 'Removing database tables...');
        $modelPath = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path') . 'components/scheduler/') . 'model/';
        $modx->addPackage('scheduler', $modelPath);

        $manager = $modx->getManager();

        // Suppress table removal logging
        $oldLogLevel = $modx->getLogLevel();
        $modx->setLogLevel(0);

        $manager->removeObjectContainer('sTask');
        $manager->removeObjectContainer('sTaskRun');

        // Restore logging
        $modx->setLogLevel($oldLogLevel);

        break;
}

return true;