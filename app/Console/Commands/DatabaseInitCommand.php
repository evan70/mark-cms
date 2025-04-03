<?php

namespace App\Console\Commands;

use App\Services\DatabaseInitializerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DatabaseInitCommand extends Command
{
    /**
     * @var DatabaseInitializerService
     */
    private DatabaseInitializerService $databaseInitializer;
    
    /**
     * DatabaseInitCommand constructor.
     *
     * @param DatabaseInitializerService $databaseInitializer
     */
    public function __construct(DatabaseInitializerService $databaseInitializer)
    {
        parent::__construct();
        $this->databaseInitializer = $databaseInitializer;
    }
    
    /**
     * Configure the command
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('db:init')
            ->setDescription('Initialize the database schema')
            ->addOption(
                'reset',
                'r',
                InputOption::VALUE_NONE,
                'Reset the database (drop all tables and recreate them)'
            )
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the operation without confirmation'
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
        
        $reset = $input->getOption('reset');
        $force = $input->getOption('force');
        
        if ($reset) {
            if (!$force && !$io->confirm('This will drop all tables and recreate them. Are you sure?', false)) {
                $io->warning('Operation cancelled.');
                return Command::SUCCESS;
            }
            
            $io->section('Resetting database schema...');
            $this->databaseInitializer->reset();
            $io->success('Database schema reset successfully.');
        } else {
            if ($this->databaseInitializer->isInitialized()) {
                $io->info('Database is already initialized.');
                
                if (!$force && !$io->confirm('Do you want to reinitialize the database?', false)) {
                    $io->warning('Operation cancelled.');
                    return Command::SUCCESS;
                }
            }
            
            $io->section('Initializing database schema...');
            $this->databaseInitializer->initialize();
            $io->success('Database schema initialized successfully.');
        }
        
        return Command::SUCCESS;
    }
}
