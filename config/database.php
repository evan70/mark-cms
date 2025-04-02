<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'sqlite',
    'database'  => __DIR__ . '/../database/database.sqlite',
    'prefix'    => '',
]);

// Ensure database directory exists and is writable
$databaseDir = __DIR__ . '/../database';
if (!is_dir($databaseDir)) {
    mkdir($databaseDir, 0755, true);
}

// Create database file if it doesn't exist
$databaseFile = $capsule->getDatabaseManager()->getDatabaseName();
if (!file_exists($databaseFile)) {
    touch($databaseFile);
    chmod($databaseFile, 0666);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;
