<?php
$xpdo_meta_map['sTask']= array (
  'package' => 'scheduler',
  'version' => '1.1',
  'table' => 'scheduler_task',
  'fields' => 
  array (
    'class_key' => 'sSnippetTask',
    'content' => '',
    'namespace' => 'core',
    'reference' => 'Untitled Task',
    'description' => NULL,
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
