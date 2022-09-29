<?php

namespace App\Share\Services;

use App\Share\entyties\AbcDefRegionsNormalize;
use App\Share\entyties\vo\AbcDefRegion;

class AbcDefNormalizer
{
    public function __construct(private AbcDefRegionsNormalize $regionMap)
    {
    }

    private const SUBJECTS = [
        # Города
        'г.' => 'city',
        'ЗАТО' => 'city',
        'Улус' => 'city',
        'г.о.' => 'city',
        'г.о' => 'city',
        'г.п.' => 'city',
        # Районы
        'у.' => 'district',
        'мкр.' => 'district',
        'м.о.' => 'district',
        'р-н' => 'district',
        'р-ны' => 'district',
        'Российская' => 'district',
        'Сургутский' => 'district',
        'м.р.' => 'district',
        'округ' => 'district',
        # Регионы
        'Республика' => 'region',
        'область' => 'region',
        'АО' => 'region',
        'Югра' => 'region',
        'Чувашия' => 'region',
        'край' => 'region',
        # Деревни
        'с.' => 'village',
        'п.' => 'village',
        'нп.' => 'village',
        'с.п.' => 'village',
        'пгт.' => 'village',
        'д.' => 'village',
        'рп.' => 'village',
        'с/с.' => 'village',
        'тер.' => 'village',
    ];

    private array $normalizeReplace = [
        'г.о. город-курорт' => 'г.',
        'г.о. город' => 'г.',
        'городской округ' => 'г.о.',
        'автономный округ' => 'АО',
        ' /Якутия/' => '',
        'Ханты - Мансийский' => 'Ханты-Мансийский',
        'м.о.' => 'м.о. ',
        'обл.' => 'область',
        'город ' => 'г. ',
        'Красноярский край, Республика Хакасия, Алтайский край, г. Москва, г. Санкт-Петербург, Новосибирская область, Самарская область, Нижегородская область, Свердловская область, Иркутская область, Кемеровская область, Омская область, Тюменская область, Ростовская область, Краснодарский край' => 'Московская область',
        'Российская Федерация, кроме Чукотского автономного округа' => 'Московская область',
        'Российская Федерация, за исключением Чеченской Республики, Республики Крым и города Севастополь' => 'Московская область',
        'Российская Федерация, за исключением Еврейской автономной области' => 'Московская область',
        'Сибирский федеральный округ, Дальневосточный федеральный округ' => 'Новосибирская область',
        'Уральский федеральный округ, Приволжский федеральный округ' => 'Свердловская область',
        'г. Москва и Московская область' => 'Московская область',
        'Москва и Московская область' => 'Московская область',
        'г. Санкт-Петербург и Ленинградская область' => 'Ленинградская область',
        'Архангельская область и Ненецкий АО' => 'Архангельская область',
        'Республика Крым и г. Севастополь' => 'Республика Крым'
    ];


    public function buildRegion(string $region): AbcDefRegion  // получаем массив из города, района, области
    {

        $splitRegion = $this->splitRegion($region);

        $responseRegion = new AbcDefRegion(null, null, null, null, $splitRegion);

        foreach ($splitRegion as $item) {

            $item = $this->normalizeRegion($item);

            $splitItem = explode(' ', $item);

            foreach ($splitItem as $value) {
                if (isset(self::SUBJECTS[$value])) {
                    switch (self::SUBJECTS[$value]) {
                        case 'city':
                            $responseRegion->setCity($item);
                            break;
                        case 'district':
                            $responseRegion->setDistrict($item);
                            break;
                        case 'region':
                            $responseRegion->setRegion($item);
                            break;
                        case 'village':
                            $responseRegion->setVillage($item);
                            break;
                    }
                    break;
                }
            }
        }

        if (!$responseRegion->isRegion()) {
            $newRegion = $this->recoveryRegion($responseRegion->getValueIsEmptyRegion());
            $responseRegion->setRegion($newRegion);
        }
        return $responseRegion;
    }

    private function splitRegion(string $region): array
    {
        $response = [];
        $regionArray = explode('|', $region);
        foreach ($regionArray as $item) {
            $response = array_merge($response, explode(' * ', $item));
        }
        return $response;
    }


    private function normalizeRegion(string $region): string  // получаем элемент региона, города
    {
        foreach ($this->normalizeReplace as $search => $replace) {
            if (strpos($region, $search) !== false) {
                $region = str_replace('  ', ' ', str_replace($search, $replace, $region));
            }
        }

        return $region;
    }

    public function isNormalRegion(string $region): bool
    {
        return $this->regionMap->isMapRegion($region);
    }

    public function recoveryRegion(string $region): string
    {
        if (!$this->isNormalRegion($region)) {
            throw new \Exception('UNKNOWN REGION: ' . $region);
        }
        return $this->regionMap->getRegionByAddress($region)->getRegion();
    }
}