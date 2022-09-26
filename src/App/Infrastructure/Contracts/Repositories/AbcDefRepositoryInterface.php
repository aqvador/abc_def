<?php

namespace App\Infrastructure\Contracts\Repositories;

use App\Share\entyties\AbcDef;

interface AbcDefRepositoryInterface
{
    public function add(AbcDef $item): bool;

    public function findByNumber(string $number): ?AbcDef;

    public function clearTable(): bool;

}