<?php

namespace helper;

class filters extends \Prefab
{
    public function url(string $string) : string
    {
        return rawurlencode($string);
    }
    public function nounderline(string $string) : string
    {
        return str_replace("_", " ", $string);
    }
    public function timestamp(string $string) : string
    {
        $timestamp = parsers::timestamp($string);
        return implode("-", [$timestamp['day'], $timestamp['month'], $timestamp['year']]).' '
            .implode(":", [$timestamp['hour'], $timestamp['minute']]);
    }

    public function token_js(array $array, string $column = null, string $quote = "'") : string
    {
        if (!!$column) {
            $elements = array_column($array, $column);
        } else {
            $elements = $array;
        }
        $elements = array_map(function ($f) use ($quote) {
            return "{$quote}{$f}{$quote}";
        }, $elements);
        return implode(",", $elements);
    }

    public static function registry()
    {
        \Template::instance()->filter('url', '\helper\formaters::instance()->url');
        \Template::instance()->filter('nounderline', '\helper\formaters::instance()->nounderline');
        \Template::instance()->filter('timestamp', '\helper\formaters::instance()->timestamp');
    }
}
