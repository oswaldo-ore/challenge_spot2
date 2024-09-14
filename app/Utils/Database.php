<?php
namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\DB;

class Database
{
    /**
     * Create a new database.
     * @param string $dbName
     * @param string $charset
     * @param string $collation
     * @return bool
     * @throws Exception
    */
    public static function createDatabase($dbName, $charset = 'utf8mb4', $collation = 'utf8mb4_unicode_ci')
    {
        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET $charset COLLATE $collation;");
            return true;
        } catch (Exception $e) {
            throw new Exception("Error creating database: " . $e->getMessage());
        }
    }

    /**
     * Verify the database connection.
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @return bool
     */
    public static function checkConnection($host, $username, $password)
    {
        try {
            config([
                'database.connections.mysql.host' => $host,
                'database.connections.mysql.username' => $username,
                'database.connections.mysql.password' => $password,
                'database.connections.mysql.database' => null
            ]);

            DB::purge('mysql');
            DB::reconnect('mysql');
            DB::connection()->getPdo();
            return true;
        } catch (Exception $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }
}
