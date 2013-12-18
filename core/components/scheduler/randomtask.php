<?php
/**
 * @var modX $modx
 * @var sTask $task
 * @var sTaskRun $run
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

$run->addError('random_error', array(
    'random_number' => rand(0, 99999)
));

return implode('<br>', $return);
