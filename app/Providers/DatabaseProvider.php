<?php

namespace App\Providers;

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseProvider
{
    public static function boot()
    {
        $capsule = new Capsule;

        // Get absolute path to database file
        $databasePath = realpath(__DIR__ . '/../../database') ?: __DIR__ . '/../../database';
        $databaseFile = $databasePath . '/database.sqlite';

        // Create database directory if it doesn't exist
        if (!is_dir($databasePath)) {
            mkdir($databasePath, 0755, true);
        }

        // Create database file if it doesn't exist
        if (!file_exists($databaseFile)) {
            touch($databaseFile);
            chmod($databaseFile, 0666);
        }

        $capsule->addConnection([
            'driver'    => 'sqlite',
            'database'  => $databaseFile,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Make this Capsule instance available globally
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM
        $capsule->bootEloquent();

        // Verify database connection
        try {
            $capsule->getConnection()->getPdo();
        } catch (\Exception $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            error_log('Database path: ' . $databaseFile);
            error_log('Current permissions: ' . substr(sprintf('%o', fileperms($databaseFile)), -4));
            throw $e;
        }
    }
}
