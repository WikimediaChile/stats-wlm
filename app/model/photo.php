<?php

namespace model;

use helper\database;

class photo extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(database::context(), 'photo');
    }

    public static function filtering(array $filter, array $options = ['limit' =>  24, 'offset' => 0, 'order' => 'photo_date']) : array
    {
        return (new self)->find(self::prepare($filter), $options);
    }

    public static function photos_count(array $filter) : int
    {
        return (new self)->count(self::prepare($filter));
    }

    public static function exist(array $filter) : bool
    {
        return !!(new self)->count(self::prepare($filter));
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
