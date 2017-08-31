<?php

namespace route;

use helper\paginator;

class routing
{
    public static function statsCountry(\Base $fat) : \Base
    {
        $year = $fat->exists('PARAMS.year') ? (int)$fat->get('PARAMS.year') : (int)$fat->get('site.YEAR');
        $country = $fat->get('PARAMS.country');

        $fat->mset([
            'participation' => \model\participation::data($country, $year),
            'uploads' => \model\daily_contributions::data($country, $year),
            'daily' => \model\daily_participation::data($country, $year),
            'country' => \model\country_stats::data($country),
        ], 'stats_');
        $fat->set('country', \helper\country::getName($country));
        $fat->set('contenido', 'country.htm');

        return $fat;
    }

    public static function listingCountry(\Base $fat) : \Base
    {
        $date = $fat->get('GET.date');
        $items = $fat->exists('GET.items') ? (int)$fat->get('GET.items') : 24;
        $page = $fat->exists('GET.page') ? (int)$fat->get('GET.page') : 1;
        $user = $fat->exists('GET.user') ? $fat->get('GET.user') : null;
        $date = $fat->exists('GET.date') ? $fat->get('GET.date') : null;
        $country = $fat->get('PARAMS.country');
        $year = $fat->exists('PARAMS.year') ? (int)$fat->get('PARAMS.year') : (int)$fat->get('site.year');
        $filters = ['photo_country' => $country, 'photo_year' => $year];
        if ($user) {
            $filters['photo_username'] = $user;
        }
        if ($date) {
            $filters['photo_dateformat'] = $date;
        }
        $photos = \model\photo::photos_count($filters);
        $Paginator = new paginator($photos, $items);
        $Paginator->setPage($page);
        $fat->set('params', http_build_query(['user'=>$user, 'date' => $date, 'items' => $items]));
        $fat->set('list', \model\photo::filtering($filters, ['limit' => $items, 'offset' => ($page-1)*$items]));
        $fat->set('contenido', 'list.htm');
        $fat->set('Paginator', $Paginator);

        return $fat;
    }

    public static function mainCountry(\Base $fat) : \Base
    {
        $country = $fat->get('PARAMS.country');

        $fat->mset([
            'country' => \model\country_stats::data($country),
        ], 'stats_');
        $fat->set('country', \helper\country::getName($country));
        $fat->set('contenido', 'countryMain.htm');

        return $fat;
    }

    public static function afterroute(\Base $fat) : \Base
    {
        echo \Template::instance()->render('layout.htm');
        return $fat;
    }
}
