<?php

namespace Scheduler\Model\mysql;

class sTaskRun extends \Scheduler\Model\sTaskRun
{
    public static $metaMap = [
        'package' => 'Scheduler\\Model',
        'version' => '3.0',
        'table' => 'scheduler_run',
        'tableMeta' =>
            [
                'engine' => 'InnoDB',
            ],
        'fields' =>
            [
                'status' => 0,
                'task' => 0,
                'timing' => 0,
                'data' => null,
                'task_key' => '',
                'executedon' => null,
                'processing_time' => null,
                'errors' => null,
                'message' => null,
            ],
        'fieldMeta' =>
            [
                'status' =>
                    [
                        'dbtype' => 'tinyint',
                        'precision' => '2',
                        'phptype' => 'int',
                        'null' => false,
                        'default' => 0,
                    ],
                'task' =>
                    [
                        'dbtype' => 'int',
                        'precision' => '11',
                        'phptype' => 'string',
                        'null' => false,
                        'default' => 0,
                    ],
                'timing' =>
                    [
                        'dbtype' => 'int',
                        'precision' => '20',
                        'phptype' => 'int',
                        'null' => false,
                        'default' => 0,
                    ],
                'data' =>
                    [
                        'dbtype' => 'text',
                        'phptype' => 'array',
                        'null' => true,
                    ],
                'task_key' =>
                    [
                        'dbtype' => 'varchar',
                        'precision' => '128',
                        'phptype' => 'string',
                        'null' => false,
                        'default' => '',
                    ],
                'executedon' =>
                    [
                        'dbtype' => 'int',
                        'precision' => '20',
                        'phptype' => 'int',
                        'null' => true,
                    ],
                'processing_time' =>
                    [
                        'dbtype' => 'decimal',
                        'precision' => '20,4',
                        'phptype' => 'float',
                        'null' => true,
                    ],
                'errors' =>
                    [
                        'dbtype' => 'text',
                        'phptype' => 'array',
                        'null' => true,
                    ],
                'message' =>
                    [
                        'dbtype' => 'text',
                        'phptype' => 'string',
                        'null' => true,
                    ],
            ],
        'indexes' =>
            [
                'status' =>
                    [
                        'alias' => 'status',
                        'primary' => false,
                        'unique' => false,
                        'type' => 'BTREE',
                        'columns' =>
                            [
                                'status' =>
                                    [
                                        'length' => '',
                                        'collation' => 'A',
                                        'null' => false,
                                    ],
                            ],
                    ],
                'task' =>
                    [
                        'alias' => 'task',
                        'primary' => false,
                        'unique' => false,
                        'type' => 'BTREE',
                        'columns' =>
                            [
                                'task' =>
                                    [
                                        'length' => '',
                                        'collation' => 'A',
                                        'null' => false,
                                    ],
                            ],
                    ],
                'timing' =>
                    [
                        'alias' => 'timing',
                        'primary' => false,
                        'unique' => false,
                        'type' => 'BTREE',
                        'columns' =>
                            [
                                'timing' =>
                                    [
                                        'length' => '',
                                        'collation' => 'A',
                                        'null' => false,
                                    ],
                            ],
                    ],
                'task_key' =>
                    [
                        'alias' => 'task_key',
                        'primary' => false,
                        'unique' => false,
                        'type' => 'BTREE',
                        'columns' =>
                            [
                                'task_key' =>
                                    [
                                        'length' => '',
                                        'collation' => 'A',
                                        'null' => false,
                                    ],
                            ],
                    ],
                'executedon' =>
                    [
                        'alias' => 'executedon',
                        'primary' => false,
                        'unique' => false,
                        'type' => 'BTREE',
                        'columns' =>
                            [
                                'executedon' =>
                                    [
                                        'length' => '',
                                        'collation' => 'A',
                                        'null' => false,
                                    ],
                            ],
                    ],
                'processing_time' =>
                    [
                        'alias' => 'processing_time',
                        'primary' => false,
                        'unique' => false,
                        'type' => 'BTREE',
                        'columns' =>
                            [
                                'processing_time' =>
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
                'Task' =>
                    [
                        'class' => 'Scheduler\\Model\\sTask',
                        'local' => 'task',
                        'foreign' => 'id',
                        'cardinality' => 'one',
                        'owner' => 'foreign',
                    ],
            ],
    ];
}
