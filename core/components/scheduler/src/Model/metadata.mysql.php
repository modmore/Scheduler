<?php

$xpdo_meta_map = [
    'version' => '3.0',
    'namespace' => 'Scheduler\\Model',
    'namespacePrefix' => 'Scheduler',
    'class_map' => [
        'xPDO\\Om\\xPDOSimpleObject' =>
            [
                'Scheduler\\Model\\sTask',
                'Scheduler\\Model\\sTaskRun',
            ],
        'Scheduler\\Model\\sTask' =>
            [
                'Scheduler\\Model\\sSnippetTask',
                'Scheduler\\Model\\sProcessorTask',
                'Scheduler\\Model\\sFileTask',
            ],
    ],
];
