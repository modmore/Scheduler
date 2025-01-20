<?php

namespace Scheduler\Model;

use MODX\Revolution\modSnippet;

/**
 * Class sSnippetTask
 */
class sSnippetTask extends sTask
{
    /** @var xPDO|modX $xpdo * */
    public $xpdo;

    /**
     * @param sTaskRun $run
     * @return mixed
     */
    public function _run($run)
    {
        $snippet = $this->get('content');
        $scriptProperties = (array)$run->get('data');
        $scriptProperties['task'] = $this;
        $scriptProperties['run'] = $run;

        // Check if the snippet exists before running it.
        // This may fail with OnElementNotFound snippets in 2.3
        $key = (!empty($snippet) && is_numeric($snippet)) ? 'id' : 'name';
        if ($this->xpdo->getCount(modSnippet::class, [$key => $snippet]) < 1) {
            $run->addError('snippet_not_found', ['snippet' => $snippet]);
            return false;
        }

        $snippet = $this->xpdo->getObject(modSnippet::class, [$key => $snippet]);
        if (empty($snippet) || !is_object($snippet)) {
            $run->addError('snippet_not_found', ['snippet' => $snippet]);
            return false;
        }

        $snippet->setCacheable(false);
        $out = $snippet->process($scriptProperties);
        unset($scriptProperties, $snippet);

        return $out;
    }
}
