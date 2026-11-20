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
    '.github' => true,
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

$zip = new ZipArchive;
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

// Ready Hostinger .env (DB + APP_URL filled)
$envFile = __DIR__.DIRECTORY_SEPARATOR.'.env';
if (is_file($envFile)) {
    $zip->addFile($envFile, '.env');
}

// Root .htaccess -> forwards to public/
$rootHtaccess = __DIR__.DIRECTORY_SEPARATOR.'public_html.htaccess';
if (is_file($rootHtaccess)) {
    $zip->addFile($rootHtaccess, '.htaccess');
}

$readme = <<<'TXT'
SUCHANA.BD — CLEAN HOSTINGER INSTALL (A-Z)
==========================================
Files:
- This ZIP = full site (vendor included) + ready .env
- smtii-database.sql = SEPARATE (same deploy folder on PC)

CLEAN INSTALL STEPS
-------------------
1) hPanel -> Websites -> suchana.bd -> File Manager
   Open domain public_html:
   /home/u987493658/domains/suchana.bd/public_html

2) DELETE everything inside that public_html (old/wrong files).
   Do NOT leave nested public_html or tttttttt folders.

3) Upload this ZIP into that empty public_html -> Extract.
   After extract you must see: app, public, vendor, artisan, .env

4) Domains -> suchana.bd -> Document Root =
   public_html/public
   (full path often ends with .../domains/suchana.bd/public_html/public)

5) phpMyAdmin -> database u987493658_suchana
   -> Import smtii-database.sql
   (if tables already exist, drop old tables first OR import fresh DB)

6) hPanel Terminal / SSH:
   cd ~/domains/suchana.bd/public_html
   php artisan storage:link
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   chmod -R 775 storage bootstrap/cache

7) PHP version: 8.3 or 8.4 (hPanel -> PHP Configuration)

8) Open https://suchana.bd
   Hard refresh: Ctrl+F5

.env already has:
APP_URL=https://suchana.bd
DB_DATABASE / DB_USERNAME = u987493658_suchana
SESSION_DRIVER=file
CACHE_STORE=file

Demo logins (if SQL imported):
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
