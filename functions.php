<?php declare(strict_types=1);

namespace Util;

function res(bool $type, string $msg, array $output): array {
    return [
        'success' => $type,
        'message' => $msg,
        'output' => implode("\n", $output)
    ];
}

function GetWP(): array {
    $url = 'https://wordpress.org/latest.zip';
    $cmd = 'wget ' . $url . ' 2>&1';

    exec($cmd, $output, $rv);

    if($rv === 0) {
        return res(true, "WordPress downloaded successfully.", $output);
    }
    else {
        return res(false, "Error downloading WordPress.", $output);
    }
}

function Unzip(string $archive, string $folder) {
    $cmd = 'unzip ' . $archive . ' -d ' . $folder;
    exec($cmd, $output, $rv);

    if($rv === 0) {
        return res(true, "Extracted WordPress successfully.", $output);
    }
    else {
        return res(false, "Error extracting WordPress.", $output);
    }
}

function GetRepo(string $theme): array {
    $url = 'https://github.com/WP-Toolkit/wptk-theme.git';
    $path = $theme . '/wordpress/wp-content/themes/' . $theme;
    $cmd = 'git clone ' . $url . ' ' . $path . ' 2>&1';

    exec($cmd, $output, $rv);

    if($rv === 0) {
        return res(true, "Repo cloned successfully.", $output);
    }
    else {
        return res(false, "Error cloning repo.", $output);
    }
}