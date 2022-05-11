<?php

$root = dirname(dirname(__DIR__));

$config = [
    'basePath' => $root,
    'vendorPath' => $root . '/vendor',
    'runtimePath' => $root . '/runtime',
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Yekaterinburg',
    'aliases' => [
        '@root' => $root,
        '@App' => '@root/App',
        '@resources' => '@root/resources',
        '@webroot' => '@root/web',
        '@web' => '@root/web',
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'params' => require __DIR__ . '/../params.php',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1']
    ];
}

return $config;
