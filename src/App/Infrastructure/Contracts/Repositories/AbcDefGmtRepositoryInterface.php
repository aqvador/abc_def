<?php

namespace App\Infrastructure\Contracts\Repositories;

use App\Share\entyties\AbcDefGmt;
use App\Share\entyties\AbcDefGmts;
use Ramsey\Uuid\UuidInterface;
use yii\db\Connection;

interface AbcDefGmtRepositoryInterface
{
    public function getAllItems(): ?AbcDefGmts;

    public function truncate(): bool;

    public function add(AbcDefGmt $gmt): bool;

    public function getByUuid(UuidInterface $uuid): ?AbcDefGmt;

}