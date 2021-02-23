<?php

require_once dirname(__FILE__).'/future.class.php';
/**
 * Gets a list of sTaskRun objects.
 */
class SchedulerTaskRunHistoryListProcessor extends SchedulerTaskRunFutureListProcessor {
    public $defaultSortField = 'executedon';
    public $defaultSortDirection = 'DESC';
    public $additionalWhere = array(
        'status:!=' => sTaskRun::STATUS_SCHEDULED,
    );

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $array = $object->toArray('', false, true);
        $array['task_string'] = $array['task_namespace'] . ' : ' . $array['task_reference'];

        if (!empty($array['errors'])) {
            $errors = array();
            foreach ($array['errors'] as $e) {
                $error = array();
                foreach ($e as $key => $value) {
                    if (in_array($key, array('type', 'timestamp'))) continue;
                    $error[] = '<li><b>' . htmlentities($key, ENT_QUOTES, 'UTF-8') . '</b>: ' . htmlentities($value, ENT_QUOTES, 'UTF-8') . '</li>';
                }
                $error = '<h4>' . $e['type'] . ' - ' . date('Y-m-d H:i:s', $e['timestamp']) . '</h4>'
                    . '<ul class="scheduler-list">' . implode('', $error) . '</ul>';
                $errors[] = $error;
            }
            $array['errors'] = implode('', $errors);
        }
        else {
            $array['errors'] = '';
        }

        return $array;
    }
}

return 'SchedulerTaskRunHistoryListProcessor';
