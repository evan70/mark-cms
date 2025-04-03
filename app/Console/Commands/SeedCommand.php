<?php

namespace App\Console\Commands;

use Database\Seeders\UserSeeder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SeedCommand extends Command
{
    /**
     * Configure the command
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('db:seed')
            ->setDescription('Seed the database with records')
            ->addOption(
                'class',
                'c',
                InputOption::VALUE_OPTIONAL,
                'The class name of the seeder',
                'all'
            )
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the operation to run when in production'
            );
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $class = $input->getOption('class');
        $force = $input->getOption('force');

        // Check if we are in production
        if (!$force && env('APP_ENV') === 'production') {
            $io->error('This command cannot be run in production without --force flag.');
            return Command::FAILURE;
        }

        $io->title('Database Seeder');

        if ($class === 'all') {
            $this->seedAll($io);
        } else {
            $this->seedClass($class, $io);
        }

        $io->success('Database seeded successfully!');

        return Command::SUCCESS;
    }

    /**
     * Seed all classes
     *
     * @param SymfonyStyle $io
     * @return void
     */
    private function seedAll(SymfonyStyle $io): void
    {
        $io->section('Seeding Users');
        $this->seedClass(UserSeeder::class, $io);

        // Add more seeders here as needed
    }

    /**
     * Seed a specific class
     *
     * @param string $class
     * @param SymfonyStyle $io
     * @return void
     */
    private function seedClass(string $class, SymfonyStyle $io): void
    {
        try {
            $seeder = new $class();
            $seeder->run();
            $io->text("Seeded: <info>{$class}</info>");
        } catch (\Exception $e) {
            $io->error("Failed to seed {$class}: {$e->getMessage()}");
        }
    }
}
