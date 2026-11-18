<?php

declare(strict_types=1);

$root = dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor';
$zipPath = __DIR__.DIRECTORY_SEPARATOR.'smtii-vendor.zip';

if (! is_file($root.DIRECTORY_SEPARATOR.'autoload.php')) {
    fwrite(STDERR, "vendor/autoload.php missing\n");
    exit(1);
}

if (is_file($zipPath)) {
    unlink($zipPath);
}

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Cannot create zip\n");
    exit(1);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

$count = 0;
foreach ($iterator as $file) {
    /** @var SplFileInfo $file */
    $full = $file->getPathname();
    $rel = 'vendor/'.ltrim(str_replace('\\', '/', substr($full, strlen($root))), '/');

    if ($file->isDir()) {
        $zip->addEmptyDir($rel);
        continue;
    }

    if (! $file->isFile() || ! $file->isReadable()) {
        continue;
    }

    $zip->addFile($full, $rel);
    $count++;
}

$zip->close();

echo "ZIP: {$zipPath}\n";
echo "Files: {$count}\n";
echo 'Size: '.round(filesize($zipPath) / 1048576, 2)." MB\n";
