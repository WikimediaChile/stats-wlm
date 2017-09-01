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

$fat->run();
