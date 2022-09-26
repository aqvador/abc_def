<?php

namespace App\Share\entyties;

class AbcDefGmts implements \JsonSerializable
{
    /** @var AbcDefGmt[] */
    private array $gmt;

    public function __construct(AbcDefGmt ...$gmt)
    {
        foreach ($gmt as $item) {
            $this->gmt[$item->getRegion()] = $item;
        }
    }

    public function addUniqueRegion(AbcDefGmt $gmt)
    {
        $this->gmt[$gmt->getRegion()] = $gmt;
    }

    public function searchGmtByRegion(string $region): ?AbcDefGmt
    {
        return isset($this->gmt[$region]) ? $this->gmt[$region] : null;
    }

    /**
     * @return array
     */
    public function getGmt(): array
    {
        return $this->gmt;
    }

    public function jsonSerialize()
    {
        return $this->getGmt();
    }
}