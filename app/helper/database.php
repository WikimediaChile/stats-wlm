<?php

namespace helper;

class database
{
    private static $context;

    public static function context()
    {
        if (is_null(self::$context)) {
            $dsn = sprintf('mysql:host=%s:%s;dbname=%s', \F3::get('database.server'), \F3::get('database.port'), \F3::get('database.database'));
            self::$context = new \DB\SQL($dsn, \f3::get('database.user'), \F3::get('database.password'));
        }
        return self::$context;
    }
}
