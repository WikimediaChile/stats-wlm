<?php

namespace route;

use helper\paginator;

class routing
{
    public static function statsCountry(\Base $fat) : \Base
    {
        $year = $fat->exists('PARAMS.year') ? (int)$fat->get('PARAMS.year') : (int)$fat->get('site.YEAR');
        $country = $fat->get('PARAMS.country');

        $title = $fat->format($fat->get('site.title'), $fat->get('site.CONTEST'), \helper\country::getName($country));
        $fat->set('page.title', $title);

        $fat->set('stats', \model\stats::data($country, $year));
        $fat->set('country', \helper\country::getName($country));
        $fat->set('content', 'country.htm');

        return $fat;
    }

    public static function listingCountry(\Base $fat) : \Base
    {
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

        if(!!$user && !!$date){
            $title = $fat->format($fat->get('site.photos_user_day'), $fat->get('site.CONTEST'), \helper\country::getName($country), $user, $date);
        }
        elseif(!!$date){
            $title = $fat->format($fat->get('site.photo_day'), $fat->get('site.CONTEST'), \helper\country::getName($country), $date);
        }
        elseif(!!$user){
            $title = $fat->format($fat->get('site.photo_user'), $fat->get('site.CONTEST'), \helper\country::getName($country), $user);
        }
        else{
            $title = $fat->format($fat->get('site.title'), $fat->get('site.CONTEST'), \helper\country::getName($country));
        }

        $fat->set('page.title', $title);

        $photos = \model\photo::photos_count($filters);
        $Paginator = new paginator($photos, $items);
        $Paginator->setPage($page);
        $fat->set('params', http_build_query(['user'=>$user, 'date' => $date, 'items' => $items]));
        $fat->set('list', \model\photo::filtering($filters, ['limit' => $items, 'offset' => ($page-1)*$items]));
        $fat->set('content', 'list.htm');
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
        $fat->set('content', 'countryMain.htm');

        return $fat;
    }

    public static function afterroute(\Base $fat) : \Base
    {
        echo \Template::instance()->render('layout.htm');
        return $fat;
    }
}
