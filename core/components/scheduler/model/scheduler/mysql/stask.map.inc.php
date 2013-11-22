<?php
$xpdo_meta_map['sTask']= array (
  'package' => 'scheduler',
  'version' => '1.1',
  'table' => 'scheduler_task',
  'fields' => 
  array (
    'reference' => NULL,
    'status' => 0,
    'type' => 'file',
    'executeon' => 0,
    'content' => '',
    'data' => NULL,
    'namespace' => '',
    'task' => '',
    'summary' => '',
    'completedon' => 0,
    'returned' => NULL,
    'errors' => NULL,
  ),
  'fieldMeta' => 
  array (
    'reference' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
    ),
    'status' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => false,
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '25',
      'phptype' => 'string',
      'null' => false,
      'default' => 'file',
    ),
    'executeon' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'content' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'data' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'array',
      'null' => true,
    ),
    'namespace' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'task' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'summary' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '1024',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'completedon' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'returned' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'errors' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'array',
      'null' => true,
    ),
  ),
);
