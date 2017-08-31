<?php

// Kickstart the framework
require_once "../vendor/autoload.php";

$fat = \Base::instance();
$fat->config('../config.ini');
$fat->config('../database.ini');

$fat->route('GET /*', function ($fat) {
    if ($fat->exists('GET.pais')) {
        $fat->reroute($fat->get('site.year').'/'.$fat->get('GET.pais'));
    }
});

# Wrap connection
$fat->route('GET /test', '\route\test::init');
$fat->route('GET /@year/@country/detail', '\route\routing::listingCountry');
$fat->route('GET /@year/@country', '\route\routing::statsCountry');
$fat->route('GET /@country', '\route\routing::mainCountry');

$fat->run();
