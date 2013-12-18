<?php
/**
 * Gets a list of sTaskRun objects.
 */
class sTaskRunHistoryListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sTaskRun';
    public $languageTopics = array('scheduler:default');
    public $defaultSortField = 'executedon';
    public $defaultSortDirection = 'DESC';

    /**
     * Filter on status and add task data
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->where(array(
            'status:!=' => sTaskRun::STATUS_SCHEDULED,
        ));
        $c->innerJoin('sTask', 'Task');
        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));
        $c->select($this->modx->getSelectColumns('sTask', 'Task', 'task_'));
        return $c;
    }

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $array = $object->toArray('', false, true);

        if (!empty($array['errors'])) {
            $errors = array();
            foreach ($array['errors'] as $e) {
                $error = array();
                foreach ($e as $key => $value) {
                    if (in_array($key, array('type', 'timestamp'))) continue;
                    $error[] = '<li><b>' . $key . '</b>: ' . $value . '</li>';
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
return 'sTaskRunHistoryListProcessor';
