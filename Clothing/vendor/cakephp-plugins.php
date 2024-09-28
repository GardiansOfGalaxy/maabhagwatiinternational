<?php
$baseDir = dirname(dirname(__FILE__));

return [
    'plugins' => [
        'AdminLTE' => $baseDir . '/vendor/maiconpinto/cakephp-adminlte-theme/',
        'Authentication' => $baseDir . '/vendor/cakephp/authentication/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'Cake/Twighome' => $baseDir . '/vendor/cakephp/twig-home/',
        'Crud' => $baseDir . '/vendor/friendsofcake/crud/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
    ],
];
