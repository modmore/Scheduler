<?php

class SchedulerSnippetsGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'modSnippet';
    public $objectType = 'modsnippet';
    public $defaultSortField = 'name ASC, id';
    public $defaultSortDirection = 'ASC';

    public function prepareQueryBeforeCount(xPDOQuery $c) {

        $query = $this->getProperty('query');
        if(!empty($query)) {
            $c->andCondition(array(
                'name:LIKE' => $query.'%',
            ));
        }

        return $c;
    }
}

return 'SchedulerSnippetsGetListProcessor';