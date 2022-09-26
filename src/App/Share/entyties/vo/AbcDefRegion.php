<?php

namespace App\Share\entyties\vo;

class AbcDefRegion implements \JsonSerializable
{
    public function __construct(
        private ?string $region,
        private ?string $city,
        private ?string $district,
        private ?string $village,
        private array   $stockRegion,
    )
    {

    }

    /**
     * @return array
     */
    public function getStockRegion(): array
    {
        return $this->stockRegion;
    }

    /**
     * @return null|string
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getDistrict(): ?string
    {
        return $this->district;
    }

    /**
     * @return string|null
     */
    public function getVillage(): ?string
    {
        return $this->village;
    }


    public function isRegion(): bool
    {
        return $this->getRegion() !== null;
    }

    public function getValueIsEmptyRegion(): ?string
    {
        if ($this->getRegion()) {
            return null;
        }

        if ($this->getCity()) {
            return $this->getCity();
        }
        if ($this->getDistrict()) {
            return $this->getDistrict();
        }

        if ($this->getVillage()) {
            return $this->getVillage();
        }

        return null;
    }

    /**
     * @param string|null $region
     */
    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @param string|null $district
     */
    public function setDistrict(?string $district): void
    {
        $this->district = $district;
    }

    /**
     * @param string|null $village
     */
    public function setVillage(?string $village): void
    {
        $this->village = $village;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}