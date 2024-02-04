<?php declare(strict_types=1);

if(php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use function Util\GetRepo;
use function Util\GetWP;
use function Util\Unzip;

$app = new Silly\Application();
$climate = new \League\CLImate\CLImate;

$app->command('create-project [theme]', function(string $theme) use($climate) {
    $getwp = GetWP();
    if($getwp['success']) $climate->green($getwp['message']);

    $unzip = Unzip('latest.zip');
    if($unzip['success']) $climate->green($unzip['message']);

    $getrepo = GetRepo($theme);
    if($getrepo['success']) $climate->green($getrepo['message']);
});

$app->run();