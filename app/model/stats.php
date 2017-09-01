<?php

namespace model;

class stats
{
    public static function data(string $country, int $year) : array
    {
        $data = self::getData($country, $year);
        $results = [
            'users' => user::data($data),
            'days' => days::data($data),
            'daily' => daily::data($data)];

        return $results;
    }

    private static function getData(string $country, int $year) : array
    {
        $filter = ['photo_country' => $country, 'photo_year' => $year];
        return (new photo)->select('photo_dateformat, photo_username', photo::prepare($filter));
    }
}
