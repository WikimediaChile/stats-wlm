<?php

namespace model;

use helper\database;

class daily_contributions extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(database::context(), 'daily_contributions');
    }

    public static function data(string $country, int $year) : array
    {
        $filter = ['photo_country' => $country, 'photo_year' => $year];
        return (new self)->find(self::prepare($filter), ['order' => 'day asc']);
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
