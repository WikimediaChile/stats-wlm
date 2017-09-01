<?php

namespace cli;

use \model\interface_photo;

class load
{
    public static function addData(interface_photo $Photo, string $line, int $year)
    {
        $data = array_combine(['photo_filename', 'photo_country', 'photo_date', 'photo_username', 'photo_resolution', 'photo_size', 'photo_year'], array_merge(explode(";;;", trim($line)), [$year]));
        $date = $data['photo_date'];
        $data['photo_date'] = date_create_from_format('Y-m-d\TH:i:s\Z', $date)->format("Y-m-d H:i:s");
        $data['photo_dateformat'] = date_create_from_format('Y-m-d\TH:i:s\Z', $date)->format("Y-m-d");
        if ($Photo->exist($data) === false) {
            $Photo->copyfrom($data);
            $Photo->insert();
        }
        $Photo->reset();
    }
}
