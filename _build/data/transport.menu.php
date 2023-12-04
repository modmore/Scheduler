<?php

/** @var modX $modx */
$menu = $modx->newObject('modMenu');
$menu->fromArray([
    'text' => PKG_NAME_LOWER,
    'parent' => 'components',
    'description' => PKG_NAME_LOWER . '.menu_desc',
    'icon' => '<i class="icon icon-large icon-calendar"></i>',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
    'permissions' => '',
    'namespace' => 'scheduler',
    'action' => 'index',
], '', true, true);

return $menu;
