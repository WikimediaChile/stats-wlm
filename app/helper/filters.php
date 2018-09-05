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

    function commons(string $url, int $width = 100)
    {
        $img = str_replace(" ", "_", $url);
        $md5 = md5($img);
        $url = 'https://upload.wikimedia.org/wikipedia/commons/thumb/%s/%s/%s/%spx-%s';
        if (stripos($img, '.svg') !== false) {
            $url .= '.png';
        }
        return sprintf($url, substr($md5, 0, 1), substr($md5, 0, 2), urlencode($img), $width, urlencode($img));
    }


    public static function registry()
    {
        \Template::instance()->filter('url', '\helper\formaters::instance()->url');
        \Template::instance()->filter('nounderline', '\helper\formaters::instance()->nounderline');
        \Template::instance()->filter('timestamp', '\helper\formaters::instance()->timestamp');
        \Template::instance()->filter('commons', '\helper\formaters::instance()->commons');
    }
}
