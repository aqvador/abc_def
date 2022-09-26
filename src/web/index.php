<?php
require __DIR__ . '/../vendor/autoload.php';
//
//defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG'));
//defined('YII_ENV') or define('YII_ENV', env('YII_ENV'));

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = \yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../config/common/config_common.php',
    require __DIR__ . '/../config/index-config/web.php'
);

(new yii\web\Application($config))->run();

