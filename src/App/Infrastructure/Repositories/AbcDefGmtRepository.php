<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Contracts\Repositories\AbcDefGmtRepositoryInterface;
use App\Infrastructure\Repositories\mappers\AbcDefGmtMapper;
use App\Share\entyties\AbcDefGmt;
use App\Share\entyties\AbcDefGmts;
use yii\db\Connection;

class AbcDefGmtRepository implements AbcDefGmtRepositoryInterface
{
    public function __construct(private Connection $connection, private AbcDefGmtMapper $mapper)
    {
    }

    public function queryAllRegion(): AbcDefGmts
    {
        $result = $this->connection->createCommand('SELECT * FROM abc_def_gmt')->queryAll();

        return $this->mapper->itemsMap($result);
    }

    public function add(AbcDefGmt $gmt): bool
    {
        $result = $this->connection->createCommand()->insert('abc_def_gmt', [
            'uuid' => $gmt->getUuid()->toString(),
            'region' => $gmt->getRegion(),
            'offset' => $gmt->getOffset()
        ]);
        return $result > 0;
        // TODO need released
    }

    public function truncate(): bool
    {
        $result = $this->connection->createCommand('TRUNCATE TABLE abc_def-gmt')->query();

        return  true;
        // TODO: Implement truncate() method.
    }
}