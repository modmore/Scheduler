<?php
/**
 * Gets a list of sTask objects.
 */
class sTaskGetUpcomingListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sTask';
    public $languageTopics = array('scheduler:default');
    public $defaultSortField = 'executeon';
    public $defaultSortDirection = 'ASC';

    /**
     * Only load variations for current test.
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->where(array(
            'status' => sTask::STATUS_PENDING,
        ));
        return $c;
    }
}
return 'sTaskGetUpcomingListProcessor';
