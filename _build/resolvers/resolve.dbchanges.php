<?php

/** @var xPDO|modX $modx */
$modx =& $object->xpdo;

switch($options[xPDOTransport::PACKAGE_ACTION]) {
	//case xPDOTransport::ACTION_INSTALL:
	case xPDOTransport::ACTION_UPGRADE:

        $modx->log(xPDO::LOG_LEVEL_INFO, 'Creating database tables...');
		$modelPath = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path').'components/scheduler/').'model/';
		$modx->addPackage('scheduler', $modelPath);

		$manager = $modx->getManager();

        // to not report table creation in the console
        $oldLogLevel = $modx->getLogLevel();
        $modx->setLogLevel(0);

        // changes here
        /* 2021-02-15 - add field/index for sTaskRun->task_key */
        $manager->addField('sTaskRun', 'task_key');
        $manager->addIndex('sTaskRun', 'task_key');

        // 2021-02-20
        $manager->addIndex(sTask::class, 'namespace');
        $manager->addIndex(sTask::class, 'reference');
        $manager->addIndex(sTaskRun::class, 'status');
        $manager->addIndex(sTaskRun::class, 'task');
        $manager->addIndex(sTaskRun::class, 'timing');
        $manager->addIndex(sTaskRun::class, 'executedon');

        // set back console logging
        $modx->setLogLevel($oldLogLevel);

	break;
}

return true;