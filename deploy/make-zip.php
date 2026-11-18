<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$zipPath = __DIR__.DIRECTORY_SEPARATOR.'smtii-hostinger.zip';
$sqlPath = __DIR__.DIRECTORY_SEPARATOR.'smtii-database.sql';

$excludeDirNames = [
    '.git' => true,
    '.cursor' => true,
    '.claude' => true,
    '.idea' => true,
    '.vscode' => true,
    '.zed' => true,
    '.codex' => true,
    'node_modules' => true,
    'deploy' => true,
    'tests' => true,
];

$excludeFiles = [
    '.env' => true,
    '.env.backup' => true,
    '.env.production' => true,
    'phpunit.xml' => true,
    'auth.json' => true,
    'Thumbs.db' => true,
    '.DS_Store' => true,
    'Homestead.json' => true,
    'Homestead.yaml' => true,
    'database.sqlite' => true,
    'hot' => true,
];

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
    $rel = ltrim(str_replace('\\', '/', substr($full, strlen($root))), '/');
    if ($rel === '') {
        continue;
    }

    $parts = explode('/', $rel);
    if (isset($excludeDirNames[$parts[0]])) {
        continue;
    }
    // skip nested excluded names
    foreach ($parts as $part) {
        if (isset($excludeDirNames[$part])) {
            continue 2;
        }
    }

    $base = $file->getBasename();
    if (isset($excludeFiles[$base]) || str_ends_with($base, '.log')) {
        continue;
    }

    // skip public/storage symlink/dir contents
    if (str_starts_with($rel, 'public/storage')) {
        continue;
    }

    // skip storage caches but keep folders via .gitignore placeholders
    if (preg_match('#^storage/(logs|framework/(cache/data|sessions|views)|pail)/.+#', $rel)
        && $base !== '.gitignore') {
        continue;
    }

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

// Hostinger env template
$env = <<<'ENV'
APP_NAME="Suchana SMTTI"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://YOUR-DOMAIN.com

APP_LOCALE=bn
APP_FALLBACK_LOCALE=en

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_DB_PASSWORD

SESSION_DRIVER=database
SESSION_LIFETIME=120

FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS="help@YOUR-DOMAIN.com"
MAIL_FROM_NAME="${APP_NAME}"
ENV;
$zip->addFromString('.env.hostinger', $env);

// Include ready .env if present in deploy/
$envFile = __DIR__.DIRECTORY_SEPARATOR.'.env';
if (is_file($envFile)) {
    $zip->addFile($envFile, '.env');
}

$readme = <<<'TXT'
HOSTINGER DEPLOY (FULL ZIP WITH VENDOR)
=======================================
SQL is SEPARATE: smtii-database.sql (do not put SQL inside site root only)

1) Upload this ZIP into public_html and EXTRACT
2) Domains -> suchana.bd -> Document Root = public_html/public
3) Keep/edit .env (DB already set if included)
4) phpMyAdmin -> import smtii-database.sql
5) Terminal:
   cd ~/domains/suchana.bd/public_html
   php artisan storage:link
   chmod -R 775 storage bootstrap/cache
   php artisan config:clear
6) PHP version: 8.3 or 8.4

Demo logins:
admin / password
student / password
trainer / password
TXT;
$zip->addFromString('HOSTINGER.txt', $readme);

$zip->close();

$size = filesize($zipPath);
echo "ZIP: {$zipPath}\n";
echo 'Files: '.$count."\n";
echo 'Size: '.round($size / 1048576, 2)." MB\n";
echo 'SQL: '.(is_file($sqlPath) ? round(filesize($sqlPath) / 1024, 1).' KB' : 'MISSING')."\n";
