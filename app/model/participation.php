<?php

namespace model;

use helper\database;

class participation extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(database::context(), 'participacion');
    }

    public static function data(string $country, int $year) : array
    {
        $data = self::getData($country, $year);
        $tabla = [];
        foreach ($data as $element) {
            $tabla[$element->counted][] = $element->photo_username;
        }
        krsort($tabla);
        return $tabla;
    }

    private static function getData(string $country, int $year) : array
    {
        $filter = ['photo_country' => $country, 'photo_year' => $year];
        return (new self)->find(self::prepare($filter), ['orderBy' => 'counted desc']);
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
