<?php

$params = require __DIR__ . '/../params.php';
$db = require __DIR__ . '/../Db/db.php';

$config = [
    'id' => 'app-web',
    'basePath' => dirname(dirname(__DIR__)),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'App\Http\Controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'layoutPath' => '@resources/Http/Views/layouts',
    'viewPath' => '@resources/Http/Views',
    'container' => \yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/../common/container_di_common.php',
        require __DIR__ . '/../container_di_web.php',
    ),

    'components' => \yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/../common/components_common.php',
        require __DIR__ . '/../components_web.php',
    ),
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
