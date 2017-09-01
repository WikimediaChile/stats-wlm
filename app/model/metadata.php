<?php

namespace model;

use helper\database;

class metadata extends abstract_model
{
    public function __construct()
    {
        parent::__construct(database::context(), 'other_meta');
    }
}
