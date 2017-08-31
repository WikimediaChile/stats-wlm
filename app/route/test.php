<?php

namespace route;

class test
{
    public static function init()
    {
        $Test = new \Test();
        self::testModel($Test);
        var_dump($Test->results());
    }

    public static function testModel(\Test &$test)
    {
        $Photo = new \model\photo();
        $test->expect($Photo instanceof \model\photo, '[model] photo can be instanced');
        $return = \model\photo::country('pakistan', 2016);
        $test->expect(is_array($return), '[model] method country generates array');
        $return = \model\photo::country('pakistan', 2016, ['limit' => 48]);
        $test->expect(is_array($return) && count($return) === 48, '[model] method country obtains only 48 files');
        $return = \model\photo::user('Tahira Ahmed', 2016, null);
        $test->expect(is_array($return) && count($return) > 0, '[model] method user without country');
        $return = \model\photo::user('Tahira Ahmed', 2016, 'pakistan');
        $test->expect(is_array($return) && count($return) > 0, '[model] method user with country');
        $return = \model\photo::user('Tahira Ahmed', 2016, 'invalid');
        $test->expect(is_array($return) && count($return) === 0, '[model] method user with invalid country');
    }
}
