<?php

namespace model\query;

use \helper\database;

class campaign
{
    public static function stats(string $country, int $year) : array
    {
        $sql = 'select ifnull(meta_tool, \'not-process\') meta_tool, count(1) files
            from photo
            left join other_meta
                on photo_filename = meta_filename
            where photo_country = :country
	           and photo_year = :year
           group by photo_country, photo_year, meta_tool,meta_tool
           order by 2 desc';
        return database::context()->exec($sql, ['country' => $country, 'year' => $year]);
    }

    public static function campaign(string $country, int $year, string $campaign) : array
    {
        $sql = "select photo.*
            from photo
            left join other_meta
                on photo_filename = meta_filename
            where photo_country = :country
                and photo_year = :year
                and meta_tool = :campaign";
        return database::context()->exec($sql, ['country' => $country, 'year' => $year, 'campaign' => $campaign]);
    }
}
