<?php

namespace App\Http\Controllers\Actions\AbcDef;

use App\Http\Base\BaseAction;
use App\Http\Responses\AbcDefResponse;
use App\Http\Responses\vo\Opsos;
use App\Infrastructure\Contracts\Repositories\AbcDefRepositoryInterface;
use Psr\Log\LoggerInterface;

class RegionByNumberAction extends BaseAction
{
    public function __construct(
        $id,
        $controller,
        private AbcDefRepositoryInterface $repository,
        private LoggerInterface $logger,
        $config = []
    )
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(int $number)
    {
        try {

            $item = $this->repository->findByNumber($number);

            if (!$item) {
                return $this->responseError("region by number `$number` not found", 404);
            }

            $response = new AbcDefResponse(
                $number,
                $item->getRegion()->getRegion(),
                new \DateTimeImmutable('now', new \DateTimeZone($item->getGmt()->getOffset())),
                new Opsos(
                    $item->getOpsos(),
                    $item->getInn()
                ),
                $item->getRegion()->getCity(),
            );

            return $this->responseSuccess($response);

        } catch (\Exception|\Error $error) {
            $this->logger->error('get region by number', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine()
            ]);
            return $this->responseError('unknown internal error', 501);
        }
    }
}