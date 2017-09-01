<?php

namespace helper;

class api_mediawiki
{
    public static function get(array $query_string, string $domain = 'commons.wikimedia.org')
    {
        ini_set("user_agent", "Mediawiki-php-consumer 0.1");
        $url = sprintf('https://%s/w/api.php?%s&format=json', $domain, http_build_query($query_string));
        return json_decode(\Web::instance()->request($url)['body']);
    }
}
