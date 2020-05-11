<?php
date_default_timezone_set('Europe/Zurich');

$settings = [];
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

$settings['error_handler_middleware'] = [
    'display_error_details' => true,
    'log_errors' => true,
    'log_error_details' => true,
];

$settings['doctrine'] = [
    'dev_mode' => true,
    'cache_dir' =>  $settings['root'] . '/var/doctrine',
    'metadata_dirs' => [$settings['root'] . '/src/Models'],
    'connection' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'treeMap',
        'user' => 'gegege',
        'password' => 'MWXw9$Ppmjl51drrm7',
        'charset' => 'utf8mb4'
    ]
];

return $settings;
