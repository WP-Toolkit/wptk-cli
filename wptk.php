<?php declare(strict_types=1);

if(php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use function Util\SystemExec;

$app = new Silly\Application();
$climate = new \League\CLImate\CLImate;

$app->command('new [theme]', function(string $theme) use($climate) {
    SystemExec(
        'wget https://wordpress.org/latest.zip 2>&1', 
        'WordPress downloaded successfully.', 
        'Error downloading WordPress.',
        $climate
    );

    $cmd = 'unzip latest.zip -d ' . $theme . ' 2>&1';
    SystemExec(
        $cmd, 
        'Extracted WordPress successfully.', 
        'Error extracting WordPress.',
        $climate
    );

    $url = 'https://github.com/WP-Toolkit/wptk-theme.git';
    $path = $theme . '/wordpress/wp-content/themes/' . $theme;
    $cmd = 'git clone ' . $url . ' ' . $path . ' 2>&1';
    SystemExec(
        $cmd, 
        'Repo cloned successfully.', 
        'Error cloning repo.',
        $climate
    );

    SystemExec(
        'rm -rf latest.zip',
        'Cleaned up dir',
        'Error cleaning dir',
        $climate
    );
});

$app->command('serve [theme] [port]', function(string $theme, string $port) use($climate) {
    $path = $theme . '/wordpress/';
    $cmd = 'php -S localhost:' . $port . ' -t ' . $path;
    SystemExec(
        $cmd,
        'Running local dev server...',
        'Error running local dev server',
        $climate
    );
});

/**
 * Clean up dev purposes only
 */
$app->command('clean', function() {
    exec('rm -rf latest.zip');
    exec('rm -rf mysite');
});

$app->run();