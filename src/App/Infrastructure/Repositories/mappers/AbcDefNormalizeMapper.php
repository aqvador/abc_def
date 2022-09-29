<?php

namespace App\Infrastructure\Repositories\mappers;

use App\Share\entyties\AbcDefRegionNormalize;
use App\Share\entyties\AbcDefRegionsNormalize;
use Ramsey\Uuid\Uuid;

class AbcDefNormalizeMapper
{

    public function itemMap(array $item): AbcDefRegionNormalize
    {
        return new AbcDefRegionNormalize(
            Uuid::fromString($item['uuid']),
            $item['given_address'],
            $item['relevant_region']
        );
    }


    public function itemsMap(array $items): AbcDefRegionsNormalize
    {
        $response = [];
        foreach ($items as $item) {
            $response[] = $this->itemMap($item);
        }
        return new AbcDefRegionsNormalize(... $response);
    }
}