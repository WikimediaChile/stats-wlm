<?php

ini_set('memory_limit', '256M');

// Kickstart the framework
require_once "../vendor/autoload.php";

$fat = \Base::instance();
$fat->config('../config.ini');
$fat->config('../database.ini');

$fat->set('system.git.short', exec('git rev-parse --short HEAD'));
$fat->set('system.git.full', exec('git rev-parse --short HEAD'));
$fat->set('system.codename', 'avion');

$fat->route('GET /*', function ($fat) {
    if ($fat->exists('GET.pais')) {
        $fat->reroute($fat->get('site.year').'/'.$fat->get('GET.pais'));
    }
});

# Wrap connection
$fat->route('GET /@year/@country/detail', '\route\routing::listingCountry');
$fat->route('GET /@year/@country', '\route\routing::statsCountry');
$fat->route('GET /@country', '\route\routing::mainCountry');

#filters
\helper\filters::registry();

$fat->run();
