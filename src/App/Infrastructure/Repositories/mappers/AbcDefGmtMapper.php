<?php

namespace App\Infrastructure\Repositories\mappers;

use App\Share\entyties\AbcDefGmt;
use App\Share\entyties\AbcDefGmts;
use Ramsey\Uuid\Uuid;

class AbcDefGmtMapper
{

    public function itemMap(array $item): AbcDefGmt
    {
        return new AbcDefGmt(
            Uuid::fromString($item['uuid']),
            $item['region'],
            $item['offset']
        );
    }

    public function itemsMap(array $items): AbcDefGmts
    {
        $response = [];
        foreach ($items as $item) {
            $response[] = $this->itemMap($item);
        }

        return new AbcDefGmts(...$response);

    }

}