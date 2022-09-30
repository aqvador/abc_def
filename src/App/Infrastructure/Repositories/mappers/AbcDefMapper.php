<?php

namespace App\Infrastructure\Repositories\mappers;

use App\Infrastructure\Contracts\Repositories\AbcDefGmtRepositoryInterface;
use App\Share\entyties\AbcDef;
use App\Share\entyties\vo\AbcDefRegion;
use Ramsey\Uuid\Uuid;

class AbcDefMapper
{
    public function __construct(private AbcDefGmtRepositoryInterface $repositoryGmt)
    {
    }

    public function itemMapper(array $item): ?AbcDef
    {
        $region = json_decode($item['region'], true);

        return new AbcDef(
            $item['code'],
            $item['interval_start'],
            $item['interval_end'],
            $item['capacity'],
            $item['opsos'],
            new AbcDefRegion(
                $region['region'],
                $region['city'],
                $region['district'],
                $region['village'],
                $region['stockRegion']
            ),
            $this->repositoryGmt->getByUuid(Uuid::fromString($item['gmt'])),
            $item['inn'],
            $item['version']

        );
    }
}