<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Contracts\Repositories\AbcDefRepositoryInterface;
use App\Infrastructure\Repositories\mappers\AbcDefMapper;
use App\Share\entyties\AbcDef;
use yii\db\Connection;
use yii\db\Query;

class AbcDefRepository implements AbcDefRepositoryInterface
{
    public function __construct(private Connection $connection, private AbcDefMapper $mapper)
    {
    }

    public function add(AbcDef $item): bool
    {
        $result = $this->connection->createCommand()->insert('abc_def', [
            'code' => $item->getCode(),
            'interval_start' => $item->getIntervalStart(),
            'interval_end' => $item->getIntervalEnd(),
            'capacity' => $item->getCapacity(),
            'opsos' => $item->getOpsos(),
            'region' => $item->getRegion()->getRegion(),
            'city' => $item->getRegion()->getCity(),
            'district' => $item->getRegion()->getDistrict(),
            'village' => $item->getRegion()->getVillage(),
            'inn' => (string)$item->getInn(),
            'gmt' => $item->getGmt()->getUuid()

        ])->execute();

        return $result > 0;
    }

    public function clearTable(): bool
    {
        $result = $this->connection->createCommand('TRUNCATE TABLE abc_def')->query();

        return true;


        // TODO: Implement truncate() method.
    }

    public function findByNumber(string $number): ?AbcDef
    {
        $result = $this->connection->createCommand("SELECT * FROM abc_def WHERE interval_start < $number and interval_end < $number")
            ->query();
        return  $this->mapper($result);
    }
}