<?php

namespace model;

use helper\database;

class photo extends abstract_model
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

}
