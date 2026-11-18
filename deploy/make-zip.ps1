$ErrorActionPreference = 'Stop'
$root = Split-Path -Parent $PSScriptRoot
$zipPath = Join-Path $PSScriptRoot 'smtii-hostinger.zip'
$stage = Join-Path $PSScriptRoot '_stage'

if (Test-Path $stage) { Remove-Item $stage -Recurse -Force }
New-Item -ItemType Directory -Path $stage | Out-Null

$excludeDirs = @(
  '.git', '.cursor', '.claude', '.idea', '.vscode', '.zed', '.codex',
  'node_modules', 'deploy', 'tests', 'agent-transcripts'
)

$excludeFiles = @(
  '.env', '.env.backup', '.env.production', 'phpunit.xml', 'auth.json',
  'Thumbs.db', '.DS_Store', 'Homestead.json', 'Homestead.yaml'
)

Get-ChildItem -LiteralPath $root -Force | ForEach-Object {
  $name = $_.Name
  if ($excludeDirs -contains $name) { return }
  if ($excludeFiles -contains $name) { return }
  if ($name -like '*.log') { return }
  Copy-Item -LiteralPath $_.FullName -Destination (Join-Path $stage $name) -Recurse -Force
}

# Keep storage structure, clear caches/logs/sessions
$clearGlobs = @(
  'storage\logs\*',
  'storage\framework\cache\data\*',
  'storage\framework\sessions\*',
  'storage\framework\views\*',
  'storage\pail\*'
)
foreach ($g in $clearGlobs) {
  $path = Join-Path $stage $g
  Get-ChildItem -Path $path -Force -ErrorAction SilentlyContinue |
    Where-Object { $_.Name -ne '.gitignore' } |
    Remove-Item -Recurse -Force -ErrorAction SilentlyContinue
}

# Do not ship local sqlite DB inside zip (SQL is separate)
$dbFile = Join-Path $stage 'database\database.sqlite'
if (Test-Path $dbFile) { Remove-Item $dbFile -Force }

# Remove public/hot and symlink if present
$hot = Join-Path $stage 'public\hot'
if (Test-Path $hot) { Remove-Item $hot -Force }
$pubStorage = Join-Path $stage 'public\storage'
if (Test-Path $pubStorage) { Remove-Item $pubStorage -Recurse -Force }

# Hostinger .env template (MySQL)
@"
APP_NAME="Suchana SMTTI"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://YOUR-DOMAIN.com

APP_LOCALE=bn
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_DB_PASSWORD

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS="help@YOUR-DOMAIN.com"
MAIL_FROM_NAME="`${APP_NAME}"
"@ | Set-Content -Path (Join-Path $stage '.env.hostinger') -Encoding UTF8

# Short deploy note inside zip
@"
HOSTINGER QUICK STEPS
=====================
1. Upload & extract this ZIP into your domain folder (or subdomain folder).
2. In Hostinger hPanel -> Domains -> your domain -> set Document Root to /public
   OR move public contents carefully (prefer document root = public).
3. Rename .env.hostinger to .env and fill DB + APP_URL.
4. Import smtii-database.sql from phpMyAdmin (file is OUTSIDE this zip).
5. SSH or Hostinger Terminal:
   php artisan key:generate
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
6. Make sure these folders are writable: storage, bootstrap/cache
7. Demo logins (if seeded):
   admin / password
   student / password
   trainer / password
"@ | Set-Content -Path (Join-Path $stage 'HOSTINGER.txt') -Encoding UTF8

if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

Compress-Archive -Path (Join-Path $stage '*') -DestinationPath $zipPath -CompressionLevel Optimal

Remove-Item $stage -Recurse -Force

$zip = Get-Item $zipPath
Write-Host ("ZIP: {0} ({1:N1} MB)" -f $zip.FullName, ($zip.Length / 1MB))
