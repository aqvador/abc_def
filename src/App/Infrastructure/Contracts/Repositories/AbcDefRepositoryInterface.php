<?php

namespace App\Infrastructure\Contracts\Repositories;

use App\Share\entyties\AbcDef;

interface AbcDefRepositoryInterface
{
//    public function add(AbcDef $item): bool;

    public function addItems(AbcDef ...$item): bool;

    public function findByNumber(int $number): ?AbcDef;

    public function clearTable(): bool;

}