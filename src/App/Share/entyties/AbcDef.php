<?php

namespace App\Share\entyties;

use App\Share\entyties\vo\AbcDefRegion;
use App\Share\entyties\vo\Offset;

class AbcDef implements \JsonSerializable
{
    public function __construct(
        private int          $code,
        private int          $intervalStart,
        private int          $intervalEnd,
        private int          $capacity,
        private string       $opsos,
        private AbcDefRegion $region,
        private AbcDefGmt    $gmt,
        private int          $inn,
        private int          $version

    )
    {
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @return AbcDefGmt
     */
    public function getGmt(): AbcDefGmt
    {
        return $this->gmt;
    }


    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return int
     */
    public function getIntervalStart(): int
    {
        return $this->intervalStart;
    }

    /**
     * @return int
     */
    public function getIntervalEnd(): int
    {
        return $this->intervalEnd;
    }

    /**
     * @return int
     */
    public function getCapacity(): int
    {
        return $this->capacity;
    }

    /**
     * @return int
     */
    public function getOpsos(): string
    {
        return $this->opsos;
    }

    /**
     * @return AbcDefRegion
     */
    public function getRegion(): AbcDefRegion
    {
        return $this->region;
    }

    /**
     * @return int
     */
    public function getInn(): int
    {
        return $this->inn;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}