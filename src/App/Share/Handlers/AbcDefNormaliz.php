<?php

namespace App\Share\Handlers;

use App\Share\entyties\AbcDefRegionsNormalize;
use App\Share\entyties\vo\AbcDefRegion;

class AbcDefNormaliz
{
    public function __construct(private AbcDefRegionsNormalize $regionMap)
    {
    }

    private array $normalizeReplace = [
        'г.о. город-курорт' => 'г.',
        'г.о. город' => 'г.',
        'городской округ' => 'г.о.',
        'автономный округ' => 'АО',
        ' /Якутия/' => '',
        'Ханты - Мансийский' => 'Ханты-Мансийский',
        'м.о.' => 'м.о. ',
        'обл.' => 'область',
        'город' => 'г.',
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


    public function parseRegion(array $region): AbcDefRegion  // получаем массив из города, района, области
    {

        $responseRegion = new AbcDefRegion(null, null, null, null, $region);


        foreach ($region as $item) {

            $item = $this->normalizeRegion($item);

            $currentParse = explode(' ', $item);

            switch (current($currentParse)) {
                case 'г.':
                    $responseRegion->setCity($item);
                    break;
                case 'ЗАТО':
                    $responseRegion->setCity($item);
                    break;
                case 'у.':
                    $responseRegion->setDistrict($item);
                    break;
                case 'Улус':
                    $responseRegion->setCity($item);
                    break;
                case 'мкр.':
                    $responseRegion->setDistrict($item);
                    break;
                case 'м.о.':
                    $responseRegion->setDistrict($item);
                    break;
                case 'р-н':
                    $responseRegion->setDistrict($item);
                    break;
                case 'р-ны':
                    $responseRegion->setDistrict($item);
                    break;
                case 'Российская':
                    $responseRegion->setDistrict($item);
                    break;
                case 'Московская':
                    $responseRegion->setRegion($item);
                    break;
                case 'Сургутский':
                    $responseRegion->setDistrict($item);
                    break;
                case 'с.':
                    $responseRegion->setVillage($item);
                    break;
                case 'г.о.':
                    $responseRegion->setCity($item);
                    break;
                case 'г.о':
                    $responseRegion->setCity($item);
                    break;
                case 'м.р.':
                    $responseRegion->setDistrict($item);
                    break;
                case 'г.п.':
                    $responseRegion->setCity($item);
                    break;
                case 'п.':
                    $responseRegion->setVillage($item);
                    break;
                case 'нп.':
                    $responseRegion->setVillage($item);
                    break;
                case 'с.п.':
                    $responseRegion->setVillage($item);
                    break;
                case 'пгт.':
                    $responseRegion->setVillage($item);
                    break;
                case 'д.':
                    $responseRegion->setVillage($item);
                    break;
                case 'рп.':
                    $responseRegion->setVillage($item);
                    break;
                case 'округ':
                    $responseRegion->setDistrict($item);
                    break;
                case 'с/с.':
                    $responseRegion->setVillage($item);
                    break;
                case 'тер.':
                    $responseRegion->setVillage($item);
                    break;
                case 'Республика':
                    $responseRegion->setRegion($item);
                    break;
            }

            switch (end($currentParse)) {
                case 'область':
                    $responseRegion->setRegion($item);
                    break;
                case 'АО':
                    $responseRegion->setRegion($item);
                    break;
                case 'Югра':
                    $responseRegion->setRegion($item);
                    break;
                case 'Чувашия':
                    $responseRegion->setRegion($item);
                    break;
                case 'край':
                    $responseRegion->setRegion($item);
                    break;
                case 'Республика':
                    $responseRegion->setRegion($item);
                    break;
                case 'округ':
                    $responseRegion->setDistrict($item);
                    break;
                case 'р-н':
                    $responseRegion->setDistrict($item);
                    break;
                case 'г.о.':
                    $responseRegion->setCity($item);
                    break;
            }
        }
        return $responseRegion;
    }


    private function normalizeRegion(string &$region): string  // получаем элемент региона, города
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

    public function getNormalRegion(string $region): string
    {
        if (!$this->isNormalRegion($region)) {
            throw new \Exception('UNKNOWN REGION: ' . $region);
        }
        return $this->regionMap->getRegionByAddress($region)->getRegion();
    }

}