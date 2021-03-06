<?php
$xpdo_meta_map['sTaskRun']= array (
  'package' => 'scheduler',
  'version' => '1.1',
  'table' => 'scheduler_run',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'status' => 0,
    'task' => 0,
    'timing' => 0,
    'data' => NULL,
    'task_key' => '',
    'executedon' => NULL,
    'processing_time' => NULL,
    'errors' => NULL,
    'message' => NULL,
  ),
  'fieldMeta' => 
  array (
    'status' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '2',
      'phptype' => 'int',
      'null' => false,
      'default' => 0,
    ),
    'task' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'string',
      'null' => false,
      'default' => 0,
    ),
    'timing' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'int',
      'null' => false,
      'default' => 0,
    ),
    'data' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'array',
      'null' => true,
    ),
    'task_key' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'executedon' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'int',
      'null' => true,
    ),
    'processing_time' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '20,4',
      'phptype' => 'float',
      'null' => true,
    ),
    'errors' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'array',
      'null' => true,
    ),
    'message' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'status' => 
    array (
      'alias' => 'status',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'status' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'task' => 
    array (
      'alias' => 'task',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'task' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'timing' => 
    array (
      'alias' => 'timing',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'timing' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'task_key' => 
    array (
      'alias' => 'task_key',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'task_key' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'executedon' => 
    array (
      'alias' => 'executedon',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'executedon' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'processing_time' => 
    array (
      'alias' => 'processing_time',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'processing_time' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Task' => 
    array (
      'class' => 'sTask',
      'local' => 'task',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
