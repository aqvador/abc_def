<?php

namespace App\Share\entyties;

use Ramsey\Uuid\UuidInterface;

class AbcDefGmt implements \JsonSerializable
{
    public function __construct(
        private UuidInterface $uuid,
        private string        $region,
        private string        $offset
    )
    {
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }


    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @return string
     */
    public function getOffset(): string
    {
        return $this->offset;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}