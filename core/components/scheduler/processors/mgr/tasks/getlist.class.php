<?php
/**
 * Gets a list of sTask objects.
 */
class sTaskGetUpcomingListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sTask';
    public $languageTopics = array('scheduler:default');
    public $defaultSortField = 'namespace';
    public $defaultSortDirection = 'ASC';

    /**
     * Only load variations for current test.
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));
        if (!$this->getProperty('combo')) {
            $c->select([
                "(SELECT AVG(processing_time) FROM {$this->modx->getTableName(sTaskRun::class)} WHERE `task` = sTask.id AND `status` IN (2,3) AND `processing_time` != 0.0000) AS avg_processing_time",
                "(SELECT COUNT(`id`) FROM {$this->modx->getTableName(sTaskRun::class)} WHERE `task` = sTask.id) AS runs",
            ]);
        }

        // search
        $query = $this->getProperty('query');
        if(!empty($query)) {
            $c->andCondition(array(
                'reference:LIKE' => '%'.$query.'%',
                'OR:description:LIKE' => '%'.$query.'%',
                'OR:namespace:LIKE' => '%'.$query.'%',
            ));
        }

        // filter on class key
        $classKey = $this->getProperty('class_key');
        if(!empty($classKey)) {
            $c->andCondition(array(
                'class_key' => $classKey,
            ));
        }

        // implement runs
        $subc = $this->modx->newQuery('sTaskRun');
        $subc->select($this->modx->getSelectColumns('sTaskRun', 'sTaskRun', '', array('timing')));
        $subc->where(array(
            'status' => sTaskRun::STATUS_SCHEDULED,
            '`sTaskRun`.`task` = `sTask`.`id`'
        ));
        $subc->sortby('timing', 'asc');
        $subc->limit(1);
        $subc->prepare();

        $c->select('(' . $subc->toSQL() . ') AS next_run');
        return $c;
    }

    public function prepareRow(xPDOObject $object) {
        $a = $object->toArray('', false, true);
        $a['task_string'] = $a['namespace'] . ' : ' . $a['reference'];
        $a['data'] = (!empty($a['data'])) ? $this->modx->toJSON($a['data']) : '';
        return $a;
    }
}
return 'sTaskGetUpcomingListProcessor';
