<?php

namespace App\Share\entyties;

use Ramsey\Uuid\UuidInterface;

class AbcDefRegionNormalize implements \JsonSerializable
{


    public function __construct(
        private UuidInterface $uuid,
        private string $address,
        private string $region
    )
    {
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }



    public function jsonSerialize()
    {
       return get_object_vars($this);
    }

}