<?php

namespace App\Infrastructure\Contracts\Repositories;

use App\Share\entyties\AbcDefRegionNormalize;
use App\Share\entyties\AbcDefRegionsNormalize;

interface AbcDefNormalizeRepositoryInterface
{
    public function getAllItems (): ?AbcDefRegionsNormalize;

    public function add(AbcDefRegionNormalize $item): bool;
}