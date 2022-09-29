<?php

return [
    'singletons' => [
        \App\Infrastructure\Contracts\Repositories\AbcDefNormalizeRepositoryInterface::class => [
            ['class' => \App\Infrastructure\Repositories\AbcDefNormalizeRepository::class],
            [

            ]
        ],
        \yii\di\Container::class => fn() => Yii::$container,
        \App\Share\entyties\AbcDefRegionsNormalize::class => fn(\yii\di\Container $container) => $container->get(\App\Infrastructure\Contracts\Repositories\AbcDefNormalizeRepositoryInterface::class)->getAllItems(),
        \Psr\Log\LoggerInterface::class => [
            ['class' => \Monolog\Logger::class],
            [
                'app-logger',
                [
                    (new \Monolog\Handler\RotatingFileHandler(BASE_PATH . '/runtime/logger/app-log-debug.json', 10, \Monolog\Logger::INFO))->setFormatter(new \Monolog\Formatter\JsonFormatter()),
                ],
                [
                    new \Monolog\Processor\MemoryUsageProcessor()
                ]
            ]
        ],
        \App\Share\Contracts\LoadAbcDefInterface::class => [
            ['class' => \App\Share\Handlers\LoadAbcDefHandler::class],
            [

            ]
        ],
        \App\Infrastructure\Contracts\Repositories\AbcDefRepositoryInterface::class => [
            ['class' => \App\Infrastructure\Repositories\AbcDefRepository::class],
            [
            ]
        ],

        \App\Infrastructure\Contracts\Repositories\AbcDefGmtRepositoryInterface::class => [
            ['class' => \App\Infrastructure\Repositories\AbcDefGmtRepository::class],
            [
            ]
        ],

        \yii\db\Connection::class => [
            ['class' => \yii\db\Connection::class],
            [
                [
                    'dsn' => env('DB_SHEME') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME') . ';port=' . env('DB_PORT'),
                    'username' => env('DB_USER'),
                    'password' => env('DB_PASS'),
                    'charset' => 'utf8',

                    // Schema cache options (for production environment)
                    'enableLogging' => false,
                    'enableProfiling' => false,
                    'enableSchemaCache' => env('YII_DEBUG') === false,
                    'schemaCacheDuration' => 3600,
                    'schemaCache' => 'cache'
                ]
            ]
        ],
    ],
    'definitions' => [
    ]
];