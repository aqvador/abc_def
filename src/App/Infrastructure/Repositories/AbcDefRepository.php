<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Contracts\Repositories\AbcDefRepositoryInterface;
use App\Infrastructure\Repositories\mappers\AbcDefMapper;
use App\Share\entyties\AbcDef;
use yii\db\Connection;
use yii\db\Query;

class AbcDefRepository implements AbcDefRepositoryInterface
{
    private const TABLE = 'abc_def';
    private const TABLE_COPY = 'abc_def_copy';

    public function __construct(private Connection $connection, private AbcDefMapper $mapper)
    {
    }

    public function add(AbcDef $item): bool
    {

        $result = $this->connection->createCommand()->insert(self::TABLE, [
            'code' => $item->getCode(),
            'interval_start' => $item->getIntervalStart(),
            'interval_end' => $item->getIntervalEnd(),
            'capacity' => $item->getCapacity(),
            'opsos' => $item->getOpsos(),
            'region' => $item->getRegion(),
            'inn' => (string)$item->getInn(),
            'gmt' => $item->getGmt()->getUuid(),
            'version' => $item->getVersion()

        ])->execute();

        return $result > 0;
    }

    public function addItems(AbcDef ...$items): bool
    {
        $rows = [];
        $columns = ['code', 'interval_start', 'interval_end', 'capacity', 'opsos', 'region', 'inn', 'gmt', 'version'];

        if (empty($items)) {
            return true;
        }

        foreach ($items as $item) {
            $rows[] = [
                $item->getCode(),
                $item->getIntervalStart(),
                $item->getIntervalEnd(),
                $item->getCapacity(),
                $item->getOpsos(),
                $item->getRegion(),
                (string)$item->getInn(),
                $item->getGmt()->getUuid(),
                $item->getVersion()
            ];
        }
        return $this->connection->createCommand()->batchInsert(self::TABLE, $columns, $rows)->execute() === count($items);
    }

    public function clearTable(): bool
    {
        $result = $this->connection->createCommand('TRUNCATE TABLE ' . self::TABLE)->execute();

        return $result > 0;
    }

    public function findByNumber(int $number): ?AbcDef
    {
        $result = (new Query())->from(self::TABLE)
            ->where(['code' => (int)substr($number, -10, 3)])
            ->andWhere(['<=', 'interval_start', (int)substr($number, -7)])
            ->andWhere(['>=', 'interval_end', (int)substr($number, -7)])->one($this->connection);

        if (!$result) {
            return null;
        }

        return $this->mapper->itemMapper($result);
    }

    public function getCurrentVersion(): int
    {
        $result = (new Query())
            ->select('MAX(version) as version')
            ->from(self::TABLE)
            ->createCommand($this->connection)
            ->queryScalar();

        return is_numeric($result) ? (int)$result : 0;
    }

    public function deleteVersion(int $version): bool
    {
        return $this->connection->createCommand()->delete(self::TABLE, ['version' => $version])->execute() > 0;
    }
}