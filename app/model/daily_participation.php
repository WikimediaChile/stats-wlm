<?php

namespace model;

use helper\database;

class daily_participation extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(database::context(), 'daily_participation');
    }

    public static function data(string $country, int $year) : array
    {
        $data = self::getdata($country, $year);
        $tabla = [];
        foreach ($data as $value) {
            $tabla[$value->day][] = ['user' => $value->photo_username, 'counted' => $value->counted];
        }
        ksort($tabla);
        return $tabla;
    }

    private static function getData(string $country, int $year) : array
    {
        $filter = ['photo_country' => $country, 'photo_year' => $year];
        return (new self)->find(self::prepare($filter));
    }

    private static function prepare(array $filter) : array
    {
        $where = [];
        foreach (array_keys($filter) as $item) {
            $where []= " $item = :$item";
        }
        $where = implode(' AND', $where);
        return [$where, $filter];
    }
}
