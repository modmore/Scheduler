<?php

namespace Scheduler\Model\mysql;

class sTask extends \Scheduler\Model\sTask
{
    public static $metaMap = [
        'package' => 'Scheduler\\Model',
        'version' => '3.0',
        'table' => 'scheduler_task',
        'tableMeta' =>
            [
                'engine' => 'InnoDB',
            ],
        'fields' =>
            [
                'class_key' => 'sSnippetTask',
                'content' => '',
                'namespace' => 'core',
                'reference' => 'Untitled Task',
                'description' => null,
            ],
        'fieldMeta' =>
            [
                'class_key' =>
                    [
                        'dbtype' => 'varchar',
                        'precision' => '128',
                        'phptype' => 'string',
                        'null' => false,
                        'default' => 'sSnippetTask',
                    ],
                'content' =>
                    [
                        'dbtype' => 'varchar',
                        'precision' => '256',
                        'phptype' => 'string',
                        'null' => false,
                        'default' => '',
                    ],
                'namespace' =>
                    [
                        'dbtype' => 'varchar',
                        'precision' => '128',
                        'phptype' => 'string',
                        'null' => false,
                        'default' => 'core',
                    ],
                'reference' =>
                    [
                        'dbtype' => 'varchar',
                        'precision' => '128',
                        'phptype' => 'string',
                        'null' => false,
                        'default' => 'Untitled Task',
                    ],
                'description' =>
                    [
                        'dbtype' => 'text',
                        'phptype' => 'string',
                        'null' => true,
                    ],
            ],
        'indexes' =>
            [
                'namespace' =>
                    [
                        'alias' => 'namespace',
                        'primary' => false,
                        'unique' => false,
                        'type' => 'BTREE',
                        'columns' =>
                            [
                                'namespace' =>
                                    [
                                        'length' => '',
                                        'collation' => 'A',
                                        'null' => false,
                                    ],
                            ],
                    ],
                'reference' =>
                    [
                        'alias' => 'reference',
                        'primary' => false,
                        'unique' => false,
                        'type' => 'BTREE',
                        'columns' =>
                            [
                                'reference' =>
                                    [
                                        'length' => '',
                                        'collation' => 'A',
                                        'null' => false,
                                    ],
                            ],
                    ],
            ],
        'composites' =>
            [
                'Runs' =>
                    [
                        'class' => 'Scheduler\\Model\\sTaskRun',
                        'local' => 'id',
                        'foreign' => 'task',
                        'cardinality' => 'many',
                        'owner' => 'local',
                    ],
            ],
    ];
}
