<?php

namespace model;

abstract class abstract_model extends \DB\SQL\Mapper
{
    public static function prepare(array $filter) : array
    {
        $where = [];
        foreach (array_keys($filter) as $item) {
            $where []= " $item = :$item";
        }
        $where = implode(' AND', $where);
        return [$where, $filter];
    }

    public static function exist(array $filter) : bool
    {
        return !!(new static)->count(self::prepare($filter));
    }
}
