<?php

/** @var xPDO|modX $modx */
$modx =& $object->xpdo;

switch($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
	case xPDOTransport::ACTION_UPGRADE:

        $modx->log(xPDO::LOG_LEVEL_INFO, 'Creating database tables...');
		$modelPath = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path').'components/scheduler/').'model/';
		$modx->addPackage('scheduler', $modelPath);

		$manager = $modx->getManager();

        // to not report table creation in the console
        $oldLogLevel = $modx->getLogLevel();
        $modx->setLogLevel(0);

		$manager->createObjectContainer('sTask');
        $manager->createObjectContainer('sTaskRun');

        // set back console logging
        $modx->setLogLevel($oldLogLevel);

	break;

    case xPDOTransport::ACTION_UNINSTALL:

        $modx->log(xPDO::LOG_LEVEL_INFO, 'Removing database tables...');
        $modelPath = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path').'components/scheduler/').'model/';
		$modx->addPackage('scheduler', $modelPath);

		$manager = $modx->getManager();

        // to not report table creation in the console
        $oldLogLevel = $modx->getLogLevel();
        $modx->setLogLevel(0);

        $manager->removeObjectContainer('sTask');
        $manager->removeObjectContainer('sTaskRun');

        // set back console logging
        $modx->setLogLevel($oldLogLevel);

	break;
}

return true;