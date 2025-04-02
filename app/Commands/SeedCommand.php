<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class SeedCommand extends Command
{
    protected static $defaultName = 'db:seed';

    protected function configure()
    {
        $this->setDescription('Seed the database with records');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Initialize DB connection
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../../database/database.sqlite',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // Run seeders
        $output->writeln('Seeding database...');
        
        $seeders = [
            'AdminUsersSeeder',    // Pridaný nový seeder
            'LanguagesSeeder',
            'CategoriesSeeder',
            'TagsSeeder',
            'ArticlesSeeder'
        ];

        foreach ($seeders as $seederClass) {
            $output->writeln("Running $seederClass...");
            require_once __DIR__ . "/../../database/seeds/{$seederClass}.php";
            $seeder = new $seederClass();
            $seeder->run();
        }

        $output->writeln('Database seeded successfully!');
        return Command::SUCCESS;
    }
}
