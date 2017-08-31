<?php

namespace helper;

class country
{
    public static function getName(string $country) : string
    {
        $languages = explode(",", \F3::get('LANGUAGE'))[0];
        $result = database::context()->exec('SELECT * from country where code = :country and lang = :lang', ['country' => $country, 'lang' => $languages]);
        return count($result) === 0 ? ucwords($country) : $result[0]['value'];
    }
}
