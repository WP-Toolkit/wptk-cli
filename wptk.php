<?php declare(strict_types=1);

if(php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use function Util\GetRepo;
use function Util\GetWP;
use function Util\SystemExec;
use function Util\Unzip;

$app = new Silly\Application();
$climate = new \League\CLImate\CLImate;

$app->command('create-project [theme]', function(string $theme) use($climate) {
    $task = SystemExec(
        'wget https://wordpress.org/latest.zip 2>&1', 
        'WordPress downloaded successfully.', 
        'Error downloading WordPress.'
    );
    if($task['success']) $climate->green($task['message']);

    $cmd = 'unzip latest.zip -d ' . $theme . ' 2>&1';
    $task = SystemExec(
        $cmd, 
        'Extracted WordPress successfully.', 
        'Error extracting WordPress.'
    );
    if($task['success']) $climate->green($task['message']);

    $url = 'https://github.com/WP-Toolkit/wptk-theme.git';
    $path = $theme . '/wordpress/wp-content/themes/' . $theme;
    $cmd = 'git clone ' . $url . ' ' . $path . ' 2>&1';
    $task = SystemExec(
        $cmd, 
        'Repo cloned successfully.', 
        'Error cloning repo.'
    );
    if($task['success']) $climate->green($task['message']);

    $task = SystemExec(
        'rm -rf latest.zip',
        'Cleaned up dir',
        'Error cleaning dir'
    );
    if($task['success']) $climate->green($task['message']);
});

/**
 * Clean up dev purposes only
 */
$app->command('clean', function() {
    exec('rm -rf latest.zip');
    exec('rm -rf mysite');
});

$app->run();