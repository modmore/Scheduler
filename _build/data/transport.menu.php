<?php

$menu = $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => PKG_NAME_LOWER,
    'parent' => 'components',
    'description' => PKG_NAME_LOWER.'.menu_desc',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
    'permissions' => '',
    'namespace' => 'scheduler',
    'action' => 'index',
), '', true, true);

return $menu;