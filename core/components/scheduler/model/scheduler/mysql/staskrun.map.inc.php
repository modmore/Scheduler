<?php
$xpdo_meta_map['sTaskRun']= array (
  'package' => 'scheduler',
  'version' => '1.1',
  'table' => 'scheduler_run',
  'fields' => 
  array (
    'status' => 0,
    'task' => 0,
    'timing' => 0,
    'data' => NULL,
    'executedon' => NULL,
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
    'executedon' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'int',
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
