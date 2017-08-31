<?php

namespace model;

use helper\database;

class country_stats extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(database::context(), 'country_stats');
    }

    public static function data(string $country) : array
    {
        $data = self::getdata($country, $year);
        $tabla['photos'] = array_fill_keys(range(2011, \F3::get('site.year')), 0);
        $tabla['users'] = array_fill_keys(range(2011, \F3::get('site.year')), 0);
        $tabla['ratio'] = array_fill_keys(range(2011, \F3::get('site.year')), 0);

        foreach ($data as $value) {
            $tabla['photos'][$value->photo_year] = $value->photos;
            $tabla['users'][$value->photo_year] = $value->users;
            $tabla['ratio'][$value->photo_year] = $value->photos/($value->users ?: 1);
        }
        $tabla['years'] = array_keys(array_filter($tabla['users'], function ($el) {
            return $el > 0;
        }));
        ksort($tabla);
        return $tabla;
    }

    private static function getData(string $country) : array
    {
        $filter = ['photo_country' => $country];
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
