<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Contracts\Repositories\AbcDefNormalizeRepositoryInterface;
use App\Infrastructure\Repositories\mappers\AbcDefNormalizeMapper;
use App\Share\entyties\AbcDefRegionNormalize;
use App\Share\entyties\AbcDefRegionsNormalize;
use yii\db\Connection;
use yii\db\Query;

class AbcDefNormalizeRepository implements AbcDefNormalizeRepositoryInterface
{
    private const TABLE = 'abc_def_normalize';

    public function __construct(private Connection $connection, private AbcDefNormalizeMapper $mapper)
    {
    }

    public function getAllItems(): ?AbcDefRegionsNormalize
    {
        $result = (new Query())->from(self::TABLE)->all($this->connection);
        if (!is_array($result)) {
            return null;
        }
        return $this->mapper->itemsMap($result);
    }

    public function add(AbcDefRegionNormalize $item): bool
    {
        return false;
    }
}