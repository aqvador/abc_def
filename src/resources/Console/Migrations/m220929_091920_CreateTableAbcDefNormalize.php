<?php

use yii\db\Migration;

/**
 * Class m220929_091920_CreateTableAbcDefNormalize
 */

use Ramsey\Uuid\Uuid;

class m220929_091920_CreateTableAbcDefNormalize extends Migration
{
    private const REGION_MAP = [
        'г. Байконур' => 'Республика Казахстан',
        'г.о. Пермский' => 'Пермский край',
        'г.о. Чайковский' => 'Пермский край',
        'р-н Чайковский' => 'Пермский край',
        'г.о. Березники' => 'Пермский край',
        'г.о. Красновишерск' => 'Пермский край',
        'г.о. Губаха' => 'Пермский край',
        'г.о. Лысьвенский' => 'Пермский край',
        'Лысьвенский р-н' => 'Пермский край',
        'г.о. Гремячинский' => 'Пермский край',
        'г.о. Соликамский' => 'Пермский край',
        'г.о. Соликамск' => 'Пермский край',
        'г.о. Верещагино' => 'Пермский край',
        'р-н Кизеловский' => 'Пермский край',
        'г.о. Чусовой' => 'Пермский край',
        'г.о. Чусовской' => 'Пермский край',
        'р-н Чусовский' => 'Пермский край',
        'г.о. Кудымкар' => 'Пермский край',
        'г.о. Горнозаводский' => 'Пермский край',
        'г.о. Кунгур' => 'Пермский край',
        'г.о. Нытвенский' => 'Пермский край',
        'г.о. Краснокамский' => 'Пермский край',
        'г.о. Краснокамск' => 'Пермский край',
        'г.о. Очерский' => 'Пермский край',
        'г.о. Осинский' => 'Пермский край',
        'г.о. Добрянский' => 'Пермский край',
        'г.о. Качканарский' => 'Свердловская область',
        'г.о. Нижнетуринский' => 'Свердловская область',
        'г.о. Город Лесной' => 'Свердловская область',
        'г.о. Красноуральск' => 'Свердловская область',
        'г.о. Кушвинский' => 'Свердловская область',
        'г.о. Верхняя Тура' => 'Свердловская область',
        'г.о. Верхнесалдинский' => 'Свердловская область',
        'г.о. Нижняя Салда' => 'Свердловская область',
        'м.о. Алапаевское' => 'Свердловская область',
        'г.о. Туринский' => 'Свердловская область',
        'м.о. Ирбитское' => 'Свердловская область',
        'г.о. Полевской' => 'Свердловская область',
        'г. Ирбит' => 'Свердловская область',
        'г.о. Невьянский' => 'Свердловская область',
        'Невьянский г.о.' => 'Свердловская область',
        'г.о. Кировградский' => 'Свердловская область',
        'г.о. Верхний Тагил' => 'Свердловская область',
        'г.о. Шалинский' => 'Свердловская область',
        'г.о. Горноуральский' => 'Свердловская область',
        'г.о. Тавдинский' => 'Свердловская область',
        'г.о. Артемовский' => 'Свердловская область',
        'г.о. Режевской' => 'Свердловская область',
        'г.о. Асбестовский' => 'Свердловская область',
        'г.о. Тугулымский' => 'Свердловская область',
        'г.о. Верхняя Пышма' => 'Свердловская область',
        'г.о. Среднеуральск' => 'Свердловская область',
        'г.о. Березовский' => 'Свердловская область',
        'Новоуральский г.о.' => 'Свердловская область',
        'г.о. Новоуральский' => 'Свердловская область',
        'г.о. Талицкий' => 'Свердловская область',
        'г.о. Пышминский' => 'Свердловская область',
        'г.о. Сухой Лог' => 'Свердловская область',
        'г.о. Сысертский' => 'Свердловская область',
        'г.о. Арамильский' => 'Свердловская область',
        'г.о. Камышловский' => 'Свердловская область',
        'г.о. Богданович' => 'Свердловская область',
        'г.о. Белоярский' => 'Свердловская область',
        'г.о. Заречный' => 'Свердловская область',
        'г.о. Североуральский' => 'Свердловская область',
        'г.о. Карпинск' => 'Свердловская область',
        'Волчанский г.о.' => 'Свердловская область',
        'г.о. Краснотурьинск' => 'Свердловская область',
        'г.о. Серовский' => 'Свердловская область',
        'г.о. Ивдельский' => 'Свердловская область',
        'г.о. Гаринский' => 'Свердловская область',
        'г.о. Новолялинский' => 'Свердловская область',
        'г.о. Верхотурский' => 'Свердловская область',
        'г.о. Артинский' => 'Свердловская область',
        'г.о. Ачитский' => 'Свердловская область',
        'г.о. Первоуральск' => 'Свердловская область',
        'г.о. Каменск-Уральский' => 'Свердловская область',
        'м.о. Красноуфимский округ' => 'Свердловская область',
        'г.о. Красноуфимск' => 'Свердловская область',
        'г.о. Ревда' => 'Свердловская область',
        'г. Нефтеюганск' => 'Ханты-Мансийский АО - Югра',
        'г. Когалым' => 'Ханты-Мансийский АО - Югра',
        'г. Радужный' => 'Ханты-Мансийский АО - Югра',
        'г. Ханты-Мансийск' => 'Ханты-Мансийский АО - Югра',
        'г. Уфа' => 'Республика Башкортостан',
        'г.о. Уфа' => 'Республика Башкортостан',
        'ЗАТО г. Межгорье' => 'Республика Башкортостан',
        'г. Нефтекамск' => 'Республика Башкортостан',
        'г.о. Челябинский' => 'Челябинская область',
        'г.о. Озерский' => 'Челябинская область',
        'г.о. Миасский' => 'Челябинская область',
        'г.о. Южноуральский' => 'Челябинская область',
        'г.о. Златоустовский' => 'Челябинская область',
        'г.о. Копейский' => 'Челябинская область',
        'г.о. Снежинский' => 'Челябинская область',
        'г.о. Кыштымский' => 'Челябинская область',
        'г.о. Карабашский' => 'Челябинская область',
        'г.о. Верхнеуфалейский' => 'Челябинская область',
        'г.о. Усть-Катавский' => 'Челябинская область',
        'г.о. Трехгорный' => 'Челябинская область',
        'г.о. Магнитогорский' => 'Челябинская область',
        'г. Бузулук' => 'Оренбургская область',
        'г.о. Сорочинский' => 'Оренбургская область',
        'г. Бугуруслан' => 'Оренбургская область',
        'г.о. Абдулинский' => 'Оренбургская область',
        'г.о. Кувандыкский' => 'Оренбургская область',
        'г.о. Гайский' => 'Оренбургская область',
        'г. Орск' => 'Оренбургская область',
        'г. Новотроицк' => 'Оренбургская область',
        'г.о. Симферополь' => 'Республика Крым',
        'г.о. Ялта' => 'Республика Крым',
        'г.о. Алушта' => 'Республика Крым',
        'г.о. Керчь' => 'Республика Крым',
        'г.о. Феодосия' => 'Республика Крым',
        'г.о. Джанкой' => 'Республика Крым',
        'г.о. Красноперекопск' => 'Республика Крым',
        'г.о. Судак' => 'Республика Крым',
        'г.о. Армянск' => 'Республика Крым',
        'г.о. Евпатория' => 'Республика Крым',
        'г.о. ЗАТО Северск' => 'Томская область',
        'ЗАТО г.о. Северск' => 'Томская область',
        'г.о. Новосибирск' => 'Новосибирская область',
        'г.о. Киселевский' => 'Кемеровская область',
        'м.о. Шарыповский' => 'Красноярский край',
        'м.о. Тюхтетский' => 'Красноярский край',
        'м.о. Пировский' => 'Красноярский край',
        'г.о. ЗАТО г. Зеленогорск' => 'Красноярский край',
        'ЗАТО г. Железногорск' => 'Красноярский край',
        'г.о. Ангарский' => 'Иркутская область',
        'Ангарский г.о.' => 'Иркутская область',
        'г.о. Черняховский' => 'Калининградская область',
        'г.о. Балтийский' => 'Калининградская область',
        'м.о. Зеленоградский' => 'Калининградская область',
        'г.о. Светловский' => 'Калининградская область',
        'г.о. Якутск' => 'Республика Саха',
        'г. Якутск' => 'Республика Саха',
        'м.о. г. Мирный' => 'Республика Саха',
        'у. Нерюнгринский' => 'Республика Саха',
        'Улус Нерюнгринский' => 'Республика Саха',
        'ЗАТО г. Вилючинск' => 'Камчатский край',
        'м.о. Алеутский' => 'Камчатский край',
        'м.о. Ивановский' => 'Амурская область',
        'м.о. Бурейский' => 'Амурская область',
        'м.о. Завитинский' => 'Амурская область',
        'м.о. Ромненский' => 'Амурская область',
        'м.о. Тындинский' => 'Амурская область',
        'г.о. Владивостокский' => 'Приморский край',
        'г.о. ЗАТО Большой Камень' => 'Приморский край',
        'г.о. Большой  камень' => 'Приморский край',
        'г. Фокино' => 'Приморский край',
        'м.о. Октябрьский' => 'Приморский край',
        'г.о. Уссурийский' => 'Приморский край',
        'м.о. Пограничный' => 'Приморский край',
        'м.о. Хорольский' => 'Приморский край',
        'м.о. Ханкайский' => 'Приморский край',
        'г.о. Спасск-Дальний' => 'Приморский край',
        'г.о. Лесозаводский' => 'Приморский край',
        'г.о. Дальнереченский' => 'Приморский край',
        'м.о. Пожарский' => 'Приморский край',
        'м.о. Красноармейский' => 'Приморский край',
        'г.о. Арсеньевский' => 'Приморский край',
        'м.о. Анучинский' => 'Приморский край',
        'г.о. Партизанский' => 'Приморский край',
        'г.о. Находкинский' => 'Приморский край',
        'м.о. Чугуевский' => 'Приморский край',
        'г.о. Дальнегорский' => 'Приморский край',
        'м.о. Тернейский' => 'Приморский край',
        'м.о. Лазовский' => 'Приморский край',
        'г.о. Город Южно-Сахалинск' => 'Сахалинская область',
        'г.о. Поронайский' => 'Сахалинская область',
        'г.о. Холмский' => 'Сахалинская область',
        'г.о. Корсаковский' => 'Сахалинская область',
        'г.о. Невельский' => 'Сахалинская область',
        'г.о. Долинский' => 'Сахалинская область',
        'г.о. Ногликский' => 'Сахалинская область',
        'г.о. Томаринский' => 'Сахалинская область',
        'г.о. Тымовский' => 'Сахалинская область',
        'г.о. Новооскольский' => 'Белгородская область',
        'г.о. Алексеевский' => 'Белгородская область',
        'г.о. Валуйский' => 'Белгородская область',
        'г.о. Губкинский' => 'Белгородская область',
        'г.о. Яковлевский' => 'Белгородская область',
        'г.о. Щебекинский' => 'Белгородская область',
        'г.о. Старооскольский' => 'Белгородская область',
        'г.о. Грайворонский' => 'Белгородская область',
        'г. Воронеж' => 'Воронежская область',
        'г.о. Борисоглебский' => 'Воронежская область',
        'г. Нововоронеж' => 'Воронежская область',
        'г. Липецк' => 'Липецкая область',
        'г.о. Тамбов' => 'Томбовская область',
        'м.о. Пеновский' => 'Тверская область',
        'г.о. Вышневолоцкий' => 'Тверская область',
        'г.о. Кашинский' => 'Тверская область',
        'г.о. Осташковский' => 'Тверская область',
        'м.о. Краснохолмский' => 'Тверская область',
        'м.о. Рамешковский' => 'Тверская область',
        'г.о. Удомельский' => 'Тверская область',
        'м.о. Оленинский' => 'Тверская область',
        'м.о. Лихославльский' => 'Тверская область',
        'м.о.Весьегонский' => 'Тверская область',
        'м.о. Западнодвинский' => 'Тверская область',
        'г.о. Нелидовский' => 'Тверская область',
        'м.о. Андреапольский' => 'Тверская область',
        'м.о.Селижаровский' => 'Тверская область',
        'м.о. Лесной' => 'Тверская область',
        'м.о. Сандовский' => 'Тверская область',
        'м.о. Молоковский' => 'Тверская область',
        'м.о. Спировский' => 'Тверская область',
        'м.о. Жуковский' => 'Калужская область',
        'г.о. Новозыбковский' => 'Брянская область',
        'Красноярский край, Республика Хакасия, Алтайский край, г. Москва, г. Санкт-Петербург, Новосибирская область, Самарская область, Нижегородская область, Свердловская область, Иркутская область, Кемеровская область, Омская область, Тюменская область, Ростовская область, Краснодарский край' => 'Московская область',
        'м.о. Стародубский' => 'Брянская область',
        'г.о. Калуга' => 'Калужская область',
        'г.о. Переславль-Залесский' => 'Ярославская область',
        'г. Мценск' => 'Орловская область',
        'г. Ливны' => 'Орловская область',
        'г.о. Владимир' => 'Владимирская область',
        'г.о. Ковров' => 'Владимирская область',
        'округ Муром' => 'Владимирская область',
        'о. Иваново' => 'Ивановская область',
        'г.о. Волгореченск' => 'Костромская область',
        'г. Москва' => 'Московская область',
        'г.о. Мытищи' => 'Московская область',
        'г.о. Красногорск' => 'Московская область',
        'о. Ленинский' => 'Московская область',
        'г.о. Люберцы' => 'Московская область',
        'г.о. Пушкинский' => 'Московская область',
        'г.о. Одинцовский' => 'Московская область',
        'г.о. Солнечногорск' => 'Московская область',
        'г.о. Дмитровский' => 'Московская область',
        'г.о. Рузский' => 'Московская область',
        'г. Москва (Новомосковский)' => 'Московская область',
        'г.о. Талдомский' => 'Московская область',
        'г.о. Клин' => 'Московская область',
        'г.о. Щелково' => 'Московская область',
        'г.о. Лотошино' => 'Московская область',
        'г.о. Наро-Фоминский' => 'Московская область',
        'г.о. Волоколамский' => 'Московская область',
        'г.о. Шаховская' => 'Московская область',
        'г.о. Можайский' => 'Московская область',
        'г.о. Егорьевск' => 'Московская область',
        'г.о. Орехо-Зуевский' => 'Московская область',
        'г.о. Павловский Посад' => 'Московская область',
        'г.о. Воскресенск' => 'Московская область',
        'г.о. Шатура' => 'Московская область',
        'г.о. Раменский' => 'Московская область',
        'г.о. Чехов' => 'Московская область',
        'г.о. Ступино' => 'Московская область',
        'г.о. Кашира' => 'Московская область',
        'г.о. Серебряные Пруды' => 'Московская область',
        'г.о. Сергиево-Посадский' => 'Московская область',
        'г.о. Луховицы' => 'Московская область',
        'г.о. Истра' => 'Московская область',
        'ЗАТО г.о. Восход' => 'Московская область',
        'г.о. Богородский' => 'Московская область',
        'г.о. Пушкинский, г. Красноармейск' => 'Московская область',
        'г.о. Сергиев Посад' => 'Московская область',
        'г.о. Озёры' => 'Московская область',
        'г.о. Одинцово' => 'Московская область',
        'г.о. Власиха' => 'Московская область',
        'г. Санкт - Петербург' => 'Ленинградская область',
        'г. Санкт-Петербург' => 'Ленинградская область',
        'г.п. Никольское' => 'Ленинградская область',
        'г.о. Сосновоборский' => 'Ленинградская область',
        'г.о. Петрозаводский' => 'Республика Карелия',
        'р-н Сортавальский' => 'Республика Карелия',
        'р-н Сегежский' => 'Республика Карелия',
        'р-н Медвежьегорский' => 'Республика Карелия',
        'р-н Беломорский' => 'Республика Карелия',
        'р-н Лоухский' => 'Республика Карелия',
        'р-н Кондопожский' => 'Республика Карелия',
        'р-н Суоярвский' => 'Республика Карелия',
        'г.о. Костомукшский' => 'Республика Карелия',
        'м.о. г. Мончегорск' => 'Мурманская область',
        'ЗАТО г. Североморск' => 'Мурманская область',
        'м.о. Печенгский' => 'Мурманская область',
        'г.о. Великий Новгород' => 'Новгородская область',
        'г.о. Архангельск' => 'Архангельская область',
        'м.о. Плесецкий' => 'Архангельская область',
        'г.о. Котлас' => 'Архангельская область',
        'г.о. Северодвинск' => 'Архангельская область',
        'г. Коряжма' => 'Архангельская область',
        'г. Новодвинск' => 'Архангельская область',
        'г. Нарьян-Мар' => 'Ненецкий АО',
        'г.о. Сыктывкар' => 'Республика Коми',
        'р-н Печора' => 'Республика Коми',
        'м.р. Печора' => 'Республика Коми',
        'г.о. Усинск' => 'Республика Коми',
        'г.о. Инта' => 'Республика Коми',
        'р-н Сосногорск' => 'Республика Коми',
        'м.р. Сосногорск' => 'Республика Коми',
        'г.о. Воркута' => 'Республика Коми',
        'г.о. Ухта' => 'Республика Коми',
        'ЗАТО г. Саров' => 'Нижегородская область',
        'г. Дзержинск' => 'Нижегородская область',
        'м.о. Дивеевский' => 'Нижегородская область',
        'г.о Сокольский' => 'Нижегородская область',
        'г. Первомайск' => 'Нижегородская область',
        'м.о. Вадский' => 'Нижегородская область',
        'м.о. Балахнинский' => 'Нижегородская область',
        'г. Арзамас' => 'Нижегородская область',
        'г.о. Перевозский' => 'Нижегородская область',
        'м.о. Лысковский' => 'Нижегородская область',
        'м.о. Тоншаевский' => 'Нижегородская область',
        'г. Шахунья' => 'Нижегородская область',
        'м.о. Уренский' => 'Нижегородская область',
        'м.о. Ковернинский' => 'Нижегородская область',
        'г. Бор' => 'Нижегородская область',
        'г.о. Чкаловск' => 'Нижегородская область',
        'г.о. Семеновский' => 'Нижегородская область',
        'г.о. Воротынский' => 'Нижегородская область',
        'м.о. Богородский' => 'Нижегородская область',
        'м.о. Павловский' => 'Нижегородская область',
        'м.о. Бутурлинский' => 'Нижегородская область',
        'г.о. Навашинский' => 'Нижегородская область',
        'г. Кулебаки' => 'Нижегородская область',
        'г. Выкса' => 'Нижегородская область',
        'м.о. Починковский' => 'Нижегородская область',
        'м.о. Пижанский' => 'Кировская область',
        'г.о. Саранск' => 'Республика Мордовия',
        'п. Парца' => 'Республика Мордовия',
        'г. Пенза' => 'Пензенская область',
        'г. Кузнецк' => 'Пензенская область',
        'г.о. Казань' => 'Республика Татарстан',
        'г.о. Волгоград' => 'Волгоградская область',
        'г.о. Город-герой Волгоград' => 'Волгоградская область',
        'г.о. Волжский' => 'Волгоградская область',
        'г.о. Камышин' => 'Волгоградская область',
        'г. Михайловка' => 'Волгоградская область',
        'г.о. Фролово' => 'Волгоградская область',
        'г.о. Самара' => 'Самарская область',
        'г.о. Новокуйбышевск' => 'Самарская область',
        'г.о. Чапаевск' => 'Самарская область',
        'г.о. Сызрань' => 'Самарская область',
        'г.о. Октябрьск' => 'Самарская область',
        'г.о. Похвистнево' => 'Самарская область',
        'г.о. Кинель' => 'Самарская область',
        'г.о. Отрадный' => 'Самарская область',
        'г.о. Тольятти' => 'Самарская область',
        'г.о. Жигулевск' => 'Самарская область',
        'ЗАТО Знаменск' => 'Астраханская область',
        'г.о. Набережные Челны' => 'Республика Татарстан',
        'г.о. Город-курорт Анапа' => 'Краснодарский край',
        'г.о. Город Армавир' => 'Краснодарский край',
        'г.о. Город-курорт Геленджик' => 'Краснодарский край',
        'г.о. Город Новороссийск' => 'Краснодарский край',
        'г.о. Город-курорт Сочи' => 'Краснодарский край',
        'м.о. Грачевский' => 'Ставропольский край',
        'м.о. Красногвардейский' => 'Ставропольский край',
        'г.о. Ипатовский' => 'Ставропольский край',
        'м.о. Левокумский' => 'Ставропольский край',
        'г.о. Новоалександровский' => 'Ставропольский край',
        'г.о. Изобильненский' => 'Ставропольский край',
        'м.о. Труновский' => 'Ставропольский край',
        'г.о. Петровский' => 'Ставропольский край',
        'м.о. Новоселицкий' => 'Ставропольский край',
        'г.о. Благодарненский' => 'Ставропольский край',
        'м.о. Кочубеевский' => 'Ставропольский край',
        'г.о. Советский' => 'Ставропольский край',
        'м.о. Шпаковский' => 'Ставропольский край',
        'м.о. Апанасенковский' => 'Ставропольский край',
        'м.о. Андроповский' => 'Ставропольский край',
        'м.о. Александровский' => 'Ставропольский край',
        'м.о. Буденновский' => 'Ставропольский край',
        'г.о. Нальчик' => 'Кабардино-Балкарская Республика',
        'г. Севастополь' => 'Республика Крым',
        'г.о. Минераловодский' => 'Ставропольский край',
        'г. Пятигорск' => 'Ставропольский край',
        'г. Железноводск' => 'Ставропольский край',
        'г. Ессентуки' => 'Ставропольский край',
        'г. Кисловодск' => 'Ставропольский край',
        'г.о. Кировский' => 'Ставропольский край',
        'г.о. Георгиевский' => 'Ставропольский край',
        'м.о. Предгорный' => 'Ставропольский край',
        'м.о. Курский' => 'Ставропольский край',
        'г. Сургут' => 'Ханты-Мансийский АО - Югра',
        'р-н Сургутский' => 'Ханты-Мансийский АО - Югра',
        'р-н Нефтеюганский' => 'Ханты-Мансийский АО - Югра',
        'г. Пыть-Ях' => 'Ханты-Мансийский АО - Югра',
        'г. Лянтор' => 'Ханты-Мансийский АО - Югра',
        'г. Мегион' => 'Ханты-Мансийский АО - Югра',
        'г. Нижневартовск' => 'Ханты-Мансийский АО - Югра',
        'р-н Нижневартовский' => 'Ханты-Мансийский АО - Югра',
        'г. Лангепас' => 'Ханты-Мансийский АО - Югра',
        'г. Покачи' => 'Ханты-Мансийский АО - Югра',
        'р-н Белоярский' => 'Ханты-Мансийский АО - Югра',
        'г. Белоярский' => 'Ханты-Мансийский АО - Югра',
        'р-н Ханты-Мансийский' => 'Ханты-Мансийский АО - Югра',
        'г. Нягань' => 'Ханты-Мансийский АО - Югра',
        'р-н Октябрьский' => 'Ханты-Мансийский АО - Югра',
        'г. Ханты - Мансийск' => 'Ханты-Мансийский АО - Югра',
        'р-н Березовский' => 'Ханты-Мансийский АО - Югра',
        'г. Югорск' => 'Ханты-Мансийский АО - Югра',
        'р-н Советский' => 'Ханты-Мансийский АО - Югра',
        'г. Урай' => 'Ханты-Мансийский АО - Югра',
        'р-н Кондинский' => 'Ханты-Мансийский АО - Югра',
        'г. Агидель' => 'Республика Башкортостан',
        'г. Стерлитамак' => 'Ханты-Мансийский АО - Югра',
        'г. Кумертау' => 'Ханты-Мансийский АО - Югра',
        'г. Салават' => 'Ханты-Мансийский АО - Югра',
        'г. Сибай' => 'Ханты-Мансийский АО - Югра',
        'г. Октябрьский' => 'Ханты-Мансийский АО - Югра',
        'г. Симферополь' => 'Республика Крым',
        'г.о. Петропавловск-Камчатский' => 'Камчатский край',
        'м.о. Весьегонский' => 'Тверская область',
        'м.о. Селижаровский' => 'Тверская область',
        'г.о. Иваново' => 'Ивановская область',
        'г.о. Ленинский' => 'Московская область',
        'г. Москва (Троицкий)' => 'Московская область',
        'Российская Федерация' => 'Московская область',
        'Российская Федерация, кроме Чеченской Республики' => 'Московская область',
        'Российская Федерация, кроме Чукотского автономного округа' => 'Московская область',
        'Дальневосточный федеральный округ' => 'Дальневосточный федеральный округ',
        'г. Санкт-Петербург Ленинградская область Московская область г. Москва' => 'Московская область',
        'Северо-Западный федеральный округ' => 'Северо-Западный федеральный округ',
        'Центральный федеральный округ' => 'Московская область',
        'Архангельская область и Ненецкий АО округ' => 'Архангельская область',
        'Сургутский район' => 'Ханты-Мансийский АО - Югра',
        'Сургутский район г. Сургут' => 'Ханты-Мансийский АО - Югра',
        'р-ны Абзелиловский и Белорецкий' => 'Республика Башкортостан',
        'Архангельская область Ненецкий АО округ' => 'Архангельская область',
    ];

    public function safeUp()
    {
        $this->createTable('abc_def_normalize', [
            'uuid' => 'uuid not null unique',
            'given_address' => $this->text()->notNull()->unique(),
            'relevant_region' => $this->text()->notNull()
        ]);

        foreach (self::REGION_MAP as $address => $region) {
            $this->insert('abc_def_normalize', [
                'uuid' => Uuid::uuid4()->toString(),
                'given_address' => $address,
                'relevant_region' => $region
            ]);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('abc_def_normalize');

    }


}