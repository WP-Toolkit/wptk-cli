<?php declare(strict_types=1);

namespace Util;

function Res(bool $type, string $msg, array $output): array {
    return [
        'success' => $type,
        'message' => $msg,
        'output' => implode("\n", $output)
    ];
}
function SystemExec(string $cmd, string $success, string $error): array {
    exec($cmd, $output, $rv);

    if($rv === 0) {
        return Res(true, $success, $output);
    }
    else {
        return Res(false, $error, $output);
    }
}