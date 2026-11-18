<?php

declare(strict_types=1);

$dbPath = dirname(__DIR__).DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'database.sqlite';
$outPath = __DIR__.DIRECTORY_SEPARATOR.'smtii-database.sql';

if (! is_file($dbPath)) {
    fwrite(STDERR, "SQLite database not found: {$dbPath}\n");
    exit(1);
}

$pdo = new PDO('sqlite:'.$dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$out = fopen($outPath, 'wb');
if ($out === false) {
    fwrite(STDERR, "Cannot write {$outPath}\n");
    exit(1);
}

fwrite($out, "-- SMTTI Hostinger MySQL / MariaDB import\n");
fwrite($out, '-- Generated: '.date('Y-m-d H:i:s')."\n");
fwrite($out, "SET NAMES utf8mb4;\n");
fwrite($out, "SET FOREIGN_KEY_CHECKS=0;\n");
fwrite($out, "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n\n");

$tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")
    ->fetchAll(PDO::FETCH_COLUMN);

$skip = ['cache', 'cache_locks', 'sessions', 'jobs', 'job_batches', 'failed_jobs'];

$mapType = static function (string $type, string $name, bool $pk): string {
    $t = strtoupper(trim($type));

    if ($pk && ($t === '' || str_contains($t, 'INT'))) {
        return 'BIGINT UNSIGNED';
    }

    if ($t === '' || $t === 'INTEGER') {
        return 'BIGINT';
    }
    if (str_contains($t, 'INT')) {
        return 'BIGINT';
    }
    if (in_array($t, ['REAL', 'FLOAT', 'DOUBLE', 'NUMERIC'], true)) {
        return 'DOUBLE';
    }
    if ($t === 'BLOB') {
        return 'LONGBLOB';
    }
    if ($t === 'VARCHAR' || $t === 'CHAR') {
        return 'VARCHAR(255)';
    }
    if (str_starts_with($t, 'VARCHAR') || str_starts_with($t, 'CHAR')) {
        if (preg_match('/^(VAR)?CHAR\s*\(\s*\d+\s*\)$/i', $t)) {
            return $t;
        }

        return 'VARCHAR(255)';
    }
    if (in_array($t, ['TEXT', 'CLOB'], true)) {
        return 'LONGTEXT';
    }
    if ($t === 'BOOLEAN') {
        return 'TINYINT(1)';
    }
    if (in_array($t, ['DATETIME', 'DATE', 'TIMESTAMP', 'TIME'], true)) {
        return $t;
    }

    // Laravel boolean / tiny flags often stored as integer
    if (str_ends_with($name, '_at') || in_array($name, ['created_at', 'updated_at', 'deleted_at', 'email_verified_at', 'published_at', 'issued_at', 'application_deadline'], true)) {
        return 'TIMESTAMP NULL';
    }

    return 'LONGTEXT';
};

$quoteIdent = static fn (string $name): string => '`'.str_replace('`', '``', $name).'`';

foreach ($tables as $table) {
    if (in_array($table, $skip, true)) {
        continue;
    }

    $cols = $pdo->query("PRAGMA table_info(\"{$table}\")")->fetchAll(PDO::FETCH_ASSOC);

    fwrite($out, 'DROP TABLE IF EXISTS '.$quoteIdent($table).";\n");
    fwrite($out, 'CREATE TABLE '.$quoteIdent($table)." (\n");

    $lines = [];
    $pkCols = [];
    foreach ($cols as $col) {
        $name = $col['name'];
        $pk = (int) $col['pk'] > 0;
        if ($pk) {
            $pkCols[] = $name;
        }
        $type = $mapType((string) $col['type'], $name, $pk && count(array_filter($cols, fn ($c) => (int) $c['pk'] > 0)) === 1);
        $null = ((int) $col['notnull'] === 1 && $col['dflt_value'] === null && ! $pk) ? ' NOT NULL' : '';
        if ((int) $col['notnull'] === 1 && ! $pk) {
            $null = ' NOT NULL';
        } else {
            $null = '';
        }
        $default = '';
        if ($col['dflt_value'] !== null) {
            $d = (string) $col['dflt_value'];
            if (strtoupper($d) === 'NULL') {
                $default = ' DEFAULT NULL';
            } elseif (preg_match('/^-?\d+(\.\d+)?$/', $d)) {
                $default = ' DEFAULT '.$d;
            } else {
                $default = ' DEFAULT '.$pdo->quote(trim($d, "\"'"));
            }
        }
        $auto = '';
        if ($pk && count(array_filter($cols, fn ($c) => (int) $c['pk'] > 0)) === 1 && str_contains(strtoupper((string) $col['type']), 'INT')) {
            $auto = ' AUTO_INCREMENT';
            $null = ' NOT NULL';
            $default = '';
        }
        $lines[] = '  '.$quoteIdent($name).' '.$type.$null.$default.$auto;
    }

    if (count($pkCols) === 1) {
        $lines[] = '  PRIMARY KEY ('.$quoteIdent($pkCols[0]).')';
    } elseif (count($pkCols) > 1) {
        $lines[] = '  PRIMARY KEY ('.implode(', ', array_map($quoteIdent, $pkCols)).')';
    }

    fwrite($out, implode(",\n", $lines)."\n");
    fwrite($out, ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n");

    $rows = $pdo->query("SELECT * FROM \"{$table}\"")->fetchAll(PDO::FETCH_ASSOC);
    if ($rows === []) {
        continue;
    }

    $colNames = array_keys($rows[0]);
    $colList = implode(', ', array_map($quoteIdent, $colNames));

    foreach (array_chunk($rows, 100) as $chunk) {
        $values = [];
        foreach ($chunk as $row) {
            $parts = [];
            foreach ($colNames as $c) {
                $v = $row[$c];
                if ($v === null) {
                    $parts[] = 'NULL';
                } else {
                    $parts[] = $pdo->quote((string) $v);
                }
            }
            $values[] = '('.implode(', ', $parts).')';
        }
        fwrite($out, 'INSERT INTO '.$quoteIdent($table).' ('.$colList.') VALUES'."\n");
        fwrite($out, implode(",\n", $values).";\n\n");
    }
}

fwrite($out, "SET FOREIGN_KEY_CHECKS=1;\n");
fclose($out);

echo "Wrote {$outPath}\n";
echo 'Tables: '.count(array_diff($tables, $skip))."\n";
