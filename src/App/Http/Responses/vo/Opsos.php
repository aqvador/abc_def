<?php

namespace App\Http\Responses\vo;

class Opsos implements \JsonSerializable
{
    public function __construct(
        private string $name,
        private int    $inn
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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