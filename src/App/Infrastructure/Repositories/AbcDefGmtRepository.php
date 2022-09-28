<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Contracts\Repositories\AbcDefGmtRepositoryInterface;
use App\Infrastructure\Repositories\mappers\AbcDefGmtMapper;
use App\Share\entyties\AbcDefGmt;
use App\Share\entyties\AbcDefGmts;
use Ramsey\Uuid\UuidInterface;
use yii\db\Connection;
use yii\db\Query;

class AbcDefGmtRepository implements AbcDefGmtRepositoryInterface
{
    private const TABLE = 'abc_def_gmt';

    public function __construct(private Connection $connection, private AbcDefGmtMapper $mapper)
    {
    }

    public function getByUuid(UuidInterface $uuid): ?AbcDefGmt
    {
        $result = (new Query())
            ->from(self::TABLE)
            ->where(['uuid' => $uuid->toString()])
            ->one($this->connection);

        if (!$result) {
            return null;
        }

        return $this->mapper->itemMap($result);
    }

    public function queryAllRegion(): AbcDefGmts
    {
        $result = (new Query())->from(self::TABLE)->all($this->connection);


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
        $this->connection->createCommand('TRUNCATE TABLE abc_def-gmt')->query();

        return true;
    }
}