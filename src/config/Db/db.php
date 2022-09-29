<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => env('DB_SCHEMA') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME') . ';port=' . env('DB_PORT'),
    'username' => env('DB_USER'),
    'password' => env('DB_PASS'),
    'charset' => 'utf8',
    'enableLogging' => false,
    'enableProfiling' => false,

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
