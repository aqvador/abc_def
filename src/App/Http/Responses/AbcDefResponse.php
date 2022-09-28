<?php

namespace App\Http\Responses;

use App\Http\Responses\vo\Opsos;

class AbcDefResponse implements \JsonSerializable
{
    public function __construct(
        private int     $number,
        private string  $region,
        private string  $offset,
        private Opsos   $opsos,
        private ?string $city
    )
    {
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
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

    /**
     * @return Opsos
     */
    public function getOpsos(): Opsos
    {
        return $this->opsos;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}