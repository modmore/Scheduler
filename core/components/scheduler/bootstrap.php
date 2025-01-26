<?php

/**
 * @var \MODX\Revolution\modX $modx
 * @var array $namespace
 */

// Load the classes
require_once $namespace['path'] . 'model/scheduler/scheduler.class.php';
$modx->addPackage('scheduler', $namespace['path'] . 'model/');
$modx->services->add('scheduler', function ($c) use ($modx) {
    return new Scheduler($modx);
});
