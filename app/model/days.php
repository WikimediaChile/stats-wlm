<?php

namespace model;

class days
{
    public static function data(array $data) : array
    {
        $tabla = [];
        foreach ($data as $element) {
            $tabla[$element->photo_dateformat] = 1+($tabla[$element->photo_dateformat] ?:0);
        }
        ksort($tabla);
        return $tabla;
    }
}
