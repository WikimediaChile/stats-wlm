 <?php

// Kickstart the framework
require_once "vendor/autoload.php";

$fat = \Base::instance();
$fat->config('database.ini');
$fat->set('AUTOLOAD', 'app/');

if (php_sapi_name() !== "cli") {
    die('Nothing to do here!'.PHP_EOL);
}

$fat->route('GET /import/@year', function (\Base $fat) {
    $year = (int)$fat->get('PARAMS.year');
    $filename = sprintf('files/files-%d.txt', $year);
    try {
        $file = new \SplFileObject($filename);
    } catch (\Exception $e) {
        die("File $filename not found".PHP_EOL);
    }
    \helper\database::log(false);
    // Header
    $Photo = new \model\photo;
    $file->seek($file->getSize());
    $total_files = $file->key();
    $file->rewind();
    $file->fgets();
    $i = 0;
    while ($file->eof() === false) {
        $print = implode("/", [++$i, $total_files, (memory_get_usage()/1024)]);
        fwrite(STDOUT, $print.PHP_EOL);
        \cli\load::addData($Photo, $line = $file->fgets(), $year);
    }
});

$fat->route('GET /metadata/@year', function (\Base $fat) {
    $year = (int)$fat->get('PARAMS.year');
    \helper\database::log(false);
    $res = \helper\database::context()->exec('select photo_filename
        from photo
        left join other_meta
            on photo_filename = meta_filename
        where photo_year = :year
        and meta_tool is null', ['year' => $year]);
    $result = \cli\load::getMeta(array_column($res, 'photo_filename'));
    $Result = new \ArrayObject($result->query->pages);
    $Meta = new \model\metadata;
    $i = 0;
    $total_files = count($Result);
    foreach ($Result as $page) {
        $uploaded = array_filter($page->categories, function ($f) {
            return stristr($f->title, 'Uploaded') !== false;
        });
        $campaign = array_map(function ($e) {
            return $e->title;
        }, $uploaded);

        $campaign = count($campaign) ? $campaign : ['none'];

        foreach ($campaign as $category) {
            $categoryUnPrefix = substr($category, 9);
            $data = ['meta_filename' => str_replace(" ", "_", substr($page->title, 5)),
                'meta_tool' => $categoryUnPrefix];
            $Meta->copyfrom($data);
            $Meta->save();
            $Meta->reset();
        }
        $print = implode("/", [++$i, $total_files, (memory_get_usage()/1024)]);
        fwrite(STDOUT, $print.PHP_EOL);
    }
});

$fat->run();
