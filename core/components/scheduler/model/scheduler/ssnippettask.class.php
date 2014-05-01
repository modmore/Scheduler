<?php
/**
 * Class sSnippetTask
 */
class sSnippetTask extends sTask
{
    /**
     * @param sTaskRun $run
     * @return mixed
     */
    public function _run(&$run)
    {
        $snippet = $this->get('content');
        $data['task'] =& $this;
        $data['run'] =& $run;

        // Check if the snippet exists before running it.
        // This may fail with OnElementNotFound snippets in 2.3
        $key = (!empty($snippet) && is_numeric($snippet)) ? 'id' : 'name';
        if ($this->xpdo->getCount('modSnippet', array($key => $snippet)) < 1) {
            $run->addError('snippet_not_found', array(
                'snippet' => $snippet,
            ));
            return false;
        }

        return $this->xpdo->runSnippet($snippet, $data);
    }
}