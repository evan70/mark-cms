<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Log\LoggerInterface;

class DatabaseInitializerService
{
    /**
     * @var array
     */
    private array $schema;
    
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    
    /**
     * DatabaseInitializerService constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->schema = require __DIR__ . '/../../config/database_schema.php';
        $this->logger = $logger;
    }
    
    /**
     * Initialize the database schema
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->logger->info('Initializing database schema...');
        
        foreach ($this->schema['creation_order'] as $tableName) {
            $this->createTable($tableName);
        }
        
        $this->logger->info('Database schema initialized successfully.');
    }
    
    /**
     * Reset the database schema (drop all tables and recreate them)
     *
     * @return void
     */
    public function reset(): void
    {
        $this->logger->info('Resetting database schema...');
        
        $this->dropAllTables();
        $this->initialize();
        
        $this->logger->info('Database schema reset successfully.');
    }
    
    /**
     * Create a table if it doesn't exist
     *
     * @param string $tableName
     * @return void
     */
    private function createTable(string $tableName): void
    {
        if (!Capsule::schema()->hasTable($tableName)) {
            $this->logger->info("Creating table: {$tableName}");
            
            Capsule::schema()->create($tableName, $this->schema['tables'][$tableName]);
            
            $this->logger->info("Table {$tableName} created successfully.");
        } else {
            $this->logger->info("Table {$tableName} already exists, skipping.");
        }
    }
    
    /**
     * Drop all tables in the correct order
     *
     * @return void
     */
    private function dropAllTables(): void
    {
        foreach ($this->schema['drop_order'] as $tableName) {
            if (Capsule::schema()->hasTable($tableName)) {
                $this->logger->info("Dropping table: {$tableName}");
                
                Capsule::schema()->drop($tableName);
                
                $this->logger->info("Table {$tableName} dropped successfully.");
            }
        }
    }
    
    /**
     * Check if the database is initialized
     *
     * @return bool
     */
    public function isInitialized(): bool
    {
        // Check if all tables exist
        foreach ($this->schema['creation_order'] as $tableName) {
            if (!Capsule::schema()->hasTable($tableName)) {
                return false;
            }
        }
        
        return true;
    }
}
