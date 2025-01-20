<?php

/**
 * @var \MODX\Revolution\modX $modx
 * @var array $namespace
 */

// Load the classes
$modx->addPackage('Scheduler\Model', $namespace['path'] . 'src/', null, 'Scheduler\\');

$modx->services->add('scheduler', function ($c) use ($modx) {
    return new Scheduler\Scheduler($modx);
});
