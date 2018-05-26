<?php

$params     = require __DIR__ . '/params.php';
$db         = require __DIR__ . '/db.php';
$components = require __DIR__ . '/components.php';

$config = [
    'id' => 'journal',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => $components,
    'params' => $params,
    'defaultRoute' => 'admin',
    'modules' => [
        'admin' => [
            'class' => app\modules\admin\Module::class
        ]
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '192.168.33.*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '192.168.33.*']
    ];
}

return $config;
