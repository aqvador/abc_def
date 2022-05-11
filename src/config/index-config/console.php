<?php

$params = require __DIR__ . '/../params.php';
$db = require __DIR__ . '/../Db/db.php';

$config = [
    'id' => 'app-console',
    'basePath' => dirname(dirname(__DIR__)),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'App\Console\Controllers',
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => ['@resources/Console/Migrations'],
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'container' => \yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/../common/container_di_common.php',
        require __DIR__ . '/../container_di_console.php',
    ),

    'components' => \yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/../common/components_common.php',
        require __DIR__ . '/../components_console.php',
    ),
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
