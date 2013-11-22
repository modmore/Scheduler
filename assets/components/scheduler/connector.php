<?php
/**
 * Scheduler
 *
 * Copyright 2013 by Mark Hamstra <mark@modmore.com>
 * 
 * @package scheduler
 * @var modX $modx
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';


$corePath = $modx->getOption('scheduler.core_path',null,$modx->getOption('core_path').'components/scheduler/');
require_once $corePath.'model/scheduler/scheduler.class.php';
$modx->scheduler = new Scheduler($modx);

$modx->lexicon->load('scheduler:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->scheduler->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
