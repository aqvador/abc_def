<?php

namespace App\Console\Controllers\Actions\AbcDef;

use App\Infrastructure\Contracts\Repositories\AbcDefRepositoryInterface;
use yii\base\Action;

class GetRegionByNumberAction extends Action
{
    public function __construct($id, $controller, private AbcDefRepositoryInterface $repository, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(string $number)
    {
        $response = $this->repository->findByNumber($number);

        if (!$response) {
            return null;
        }
        $answer = [
            'number' => $number,
            'city' => $response->getRegion()->getCity(),
            'region' => $response->getRegion()->getRegion(),
            'gmt' => $response->getGmt()->getOffset(),
            'opsos' => [
                'name' => $response->getOpsos(),
                'inn' => $response->getInn()
            ],
        ];

        print_r($answer);
    }
}