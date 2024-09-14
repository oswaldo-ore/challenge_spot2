<?php

namespace App\Console\Commands;

use App\Utils\Database;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';

    protected $description = 'Create a new database if it does not exist with the name specified in the .env file';

    public function handle()
    {
        $dbName = env('DB_DATABASE', false);
        if (!$dbName) {
            $this->info('No database name set in .env file');
            return;
        }
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');
        $host = env('DB_HOST', '127.0.0.1');
        if ($this->confirm("Are you sure you want to create the database `$dbName`?", true)) {
            try {
                Database::checkConnection($host, $username, $password);
                Database::createDatabase($dbName);
                $this->info("Database '$dbName' created successfully.");
            }catch (Exception $e) {
                $this->error("Error creating database: " . $e->getMessage());
                return;
            }
        } else {
            $this->info("Database creation aborted.");
        }
    }
}
