<?php

namespace App\Infrastructure\Contracts\Repositories;

use App\Share\entyties\AbcDefGmts;
use yii\db\Connection;

interface AbcDefGmtRepositoryInterface
{
    public function queryAllRegion(): AbcDefGmts;

    public  function truncate(): bool;

}