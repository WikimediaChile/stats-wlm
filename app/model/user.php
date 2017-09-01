<?php

namespace model;

class user
{
    public static function data(array $data) : array
    {
        $tabla = $return = [];
        foreach ($data as $element) {
            $tabla[$element->photo_username] = 1+($tabla[$element->photo_username] ?:0);
        }
        foreach ($tabla as $user => $count) {
            $return[$count][] = $user;
        }
        krsort($return);
        return $return;
    }
}
