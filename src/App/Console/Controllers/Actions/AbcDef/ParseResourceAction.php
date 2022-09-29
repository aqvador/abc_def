<?php

namespace App\Console\Controllers\Actions\AbcDef;

use App\Share\Contracts\LoadAbcDefInterface;
use Psr\Log\LoggerInterface;
use yii\base\Action;


class ParseResourceAction extends Action
{
    public function __construct(
        $id,
        $controller,
        private LoadAbcDefInterface $handler,
        private LoggerInterface $logger,
        $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run()
    {
        try {
            $start = time();
            $this->handler->handle(env('LINK_RESOURCE_NUMBER'));
            $handleTime = time() - $start;
            $this->logger->info('load abc def from resources', ['time' => "$handleTime sec."]);
        } catch (\Exception|\Error $e) {
            $this->logger->error('action abc def', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            exit(1);
        }

        return exit(0);
    }
}