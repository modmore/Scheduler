<?php
$xpdo_meta_map['sTask']= array (
  'package' => 'scheduler',
  'version' => '1.1',
  'table' => 'scheduler_task',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' =>
  array (
    'class_key' => 'sSnippetTask',
    'content' => '',
    'namespace' => 'core',
    'reference' => 'Untitled Task',
    'description' => NULL,
    'max_retries' => 0,
    'retry_delay' => 60,
    'recurring' => 0,
    'interval' => '',
  ),
  'fieldMeta' => 
  array (
    'class_key' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
      'default' => 'sSnippetTask',
    ),
    'content' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'namespace' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
      'default' => 'core',
    ),
    'reference' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Untitled Task',
    ),
    'description' =>
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'max_retries' =>
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'retry_delay' =>
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'default' => 60,
    ),
    'recurring' =>
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
    ),
    'interval' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '64',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
  ),
  'indexes' => 
  array (
    'namespace' => 
    array (
      'alias' => 'namespace',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'namespace' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'reference' => 
    array (
      'alias' => 'reference',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'reference' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Runs' => 
    array (
      'class' => 'sTaskRun',
      'local' => 'id',
      'foreign' => 'task',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
