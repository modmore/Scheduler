<?php
/**
 * @var modX $modx
 * @var sTask $task
 * @var array $scriptProperties
 */

$return = array();
$return[] = 'List of scriptProperties:';

var_dump($scriptProperties);

foreach ($scriptProperties as $key => $value) {
    if (is_string($value)) {
        $return[] = '<b>' . $key . '</b>: ' . $value;
    }
}

$return[] = $task->toJSON();

return implode('<br>', $return);
