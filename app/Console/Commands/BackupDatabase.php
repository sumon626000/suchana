<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';

    protected $description = 'Create a timestamped backup of the SQLite database';

    public function handle(): int
    {
        $db = database_path('database.sqlite');

        if (! is_file($db)) {
            $this->error('Database file not found at '.$db);

            return self::FAILURE;
        }

        $dest = 'backups/database-'.now()->format('Ymd-His').'.sqlite';

        Storage::disk('local')->put($dest, file_get_contents($db));

        $this->info('Backup created: storage/app/'.$dest);

        return self::SUCCESS;
    }
}
