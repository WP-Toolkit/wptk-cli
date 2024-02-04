<?php declare(strict_types=1);

namespace Util;

function Res(bool $type, string $msg, array $output): array {
    return [
        'success' => $type,
        'message' => $msg,
        'output' => implode("\n", $output)
    ];
}

function SystemExec(string $cmd, string $success, string $error, mixed $climate): mixed {
    exec($cmd, $output, $rv);

    if($rv === 0) {
        $res = Res(true, $success, $output);
        return $climate->green($res['message']);
    }
    else {
        $res = Res(false, $error, $output);
        return $climate->red("\nError: " . $res['message']);
    }
}