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
    $task = GetWP();
    if($task['success']) $climate->green($task['message']);

    $task = Unzip('latest.zip', $theme);
    if($task['success']) $climate->green($task['message']);

    $task = GetRepo($theme);
    if($task['success']) $climate->green($task['message']);

    exec('rm -rf latest.zip');
});

$app->command('clean', function() {
    exec('rm -rf latest.zip');
    exec('rm -rf mysite');
});

$app->run();