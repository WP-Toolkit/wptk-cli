<?php declare(strict_types=1);

namespace Util;

function res(bool $type, string $msg, array $output): array {
    return [
        'success' => $type,
        'message' => $msg,
        'output' => implode("\n", $output)
    ];
}
function SystemExec(string $cmd, string $success, string $error): array {
    exec($cmd, $output, $rv);

    if($rv === 0) {
        return res(true, $success, $output);
    }
    else {
        return res(false, $error, $output);
    }
}