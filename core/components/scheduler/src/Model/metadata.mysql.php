<?php

$xpdo_meta_map = [
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
];
