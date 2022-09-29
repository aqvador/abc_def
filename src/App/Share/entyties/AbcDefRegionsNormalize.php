<?php

namespace App\Share\entyties;

class AbcDefRegionsNormalize implements \JsonSerializable
{

    private array $regions;

    public function __construct(AbcDefRegionNormalize ...$items)
    {
        foreach ($items as $item) {
            $this->regions[$item->getAddress()] = $item;
        }
    }

    public function isMapRegion(string $address): bool
    {
        return isset($this->regions[$address]);
    }

    public function getRegionByAddress(string $address): ?AbcDefRegionNormalize
    {
       return isset($this->regions[$address]) ? $this->regions[$address] : null;
    }

    /**
     * @return array
     */
    public function getRegions(): array
    {
        return $this->regions;
    }


    public function jsonSerialize(): array
    {
        return $this->getRegions();
    }


}