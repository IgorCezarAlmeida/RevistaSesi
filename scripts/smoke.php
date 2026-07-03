<?php

declare(strict_types=1);

$base = dirname(__DIR__);
$phpFiles = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
);

$errors = 0;
foreach ($phpFiles as $file) {
    if ($file->getExtension() !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    if (str_contains($path, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR)) {
        continue;
    }

    $output = [];
    $status = 0;
    exec('php -l ' . escapeshellarg($path), $output, $status);

    if ($status !== 0) {
        $errors++;
        echo implode(PHP_EOL, $output) . PHP_EOL;
    }
}

if ($errors > 0) {
    echo "Smoke test falhou. Erros: {$errors}" . PHP_EOL;
    exit(1);
}

echo "Smoke test OK. Sem erros de sintaxe." . PHP_EOL;

