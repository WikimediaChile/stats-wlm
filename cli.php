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
    $filename = sprintf('files/files-%d.txt', (int)$fat->get('PARAMS.year'));
    try {
        $file = new \SplFileObject($filename);
    } catch (\Exception $e) {
        die("File $filename not found".PHP_EOL);
    }
    // Header
    $Photo = new \model\photo;
    $file->seek($file->getSize());
    $total_files = $file->key();
    $file->rewind();
    $file->fgets();
    $i = 0;
    while ($file->eof() === false) {
        $data = array_combine(['photo_filename', 'photo_country', 'photo_date', 'photo_username', 'photo_resolution', 'photo_size', 'photo_year'], array_merge(explode(";;;", trim($file->fgets())), [(int)$fat->get('PARAMS.year')]));
        fwrite(STDOUT, ++$i.'/'.$total_files.PHP_EOL);
        $date = $data['photo_date'];
        $data['photo_date'] = date_create_from_format('Y-m-d\TH:i:s\Z', $date)->format("Y-m-d H:i:s");
        $data['photo_dateformat'] = date_create_from_format('Y-m-d\TH:i:s\Z', $date)->format("Y-m-d");
        if (\model\photo::exist($data) === false) {
            $Photo->copyfrom($data);
            $Photo->save();
        }
        $Photo->reset();
    }
});

$fat->run();
