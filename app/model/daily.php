<?php

namespace model;

class daily
{
    public static function data(array $data) : array
    {
        $tabla = [];
        foreach ($data as $value) {
            $tabla[$value->photo_dateformat][$value->photo_username] = 1+($tabla[$value->photo_dateformat][$value->photo_username] ?:0);
            ;
        }
        ksort($tabla);
        return $tabla;
    }
}
