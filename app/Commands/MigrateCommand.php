<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Capsule\Manager as Capsule;

class MigrateCommand extends Command
{
    protected static $defaultName = 'db:migrate';

    protected function configure()
    {
        $this->setDescription('Run database migrations')
             ->addOption('fresh', 'f', InputOption::VALUE_NONE, 'Drop all tables before running migrations');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        require_once __DIR__ . '/../../database/migrations/20240221_init_schema.php';

        if ($input->getOption('fresh')) {
            $output->writeln('Dropping all tables...');
            $schema = new InitSchema();
            $schema->down();
        }

        $output->writeln('Running migrations...');
        
        try {
            $schema = new InitSchema();
            $schema->up();
            $output->writeln('Migrations completed successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('<error>Migration failed: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }
}
