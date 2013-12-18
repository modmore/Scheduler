<?php
/**
 * Gets a list of sTaskRun objects.
 */
class sTaskRunFutureListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sTaskRun';
    public $languageTopics = array('scheduler:default');
    public $defaultSortField = 'timing';
    public $defaultSortDirection = 'ASC';

    /**
     * Filter on status and add task data
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->where(array(
            'status' => sTaskRun::STATUS_SCHEDULED,
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
        $array['data'] = $this->modx->toJSON($array['data']);
        return $array;
    }
}
return 'sTaskRunFutureListProcessor';
