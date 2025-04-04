<?php

namespace App\Commands;

use App\Services\SearchIndexService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildSearchIndexCommand extends Command
{
    /**
     * Search index service
     *
     * @var SearchIndexService
     */
    private $indexService;
    
    /**
     * Constructor
     *
     * @param SearchIndexService $indexService Search index service
     */
    public function __construct(SearchIndexService $indexService = null)
    {
        parent::__construct();
        $this->indexService = $indexService ?? new SearchIndexService();
    }
    
    /**
     * Configure the command
     */
    protected function configure()
    {
        $this->setName('search:build-index')
             ->setDescription('Build search index')
             ->setHelp('This command builds the search index for Markdown files');
    }
    
    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Building search index...</info>');
        
        $startTime = microtime(true);
        
        $index = $this->indexService->buildIndex();
        
        $endTime = microtime(true);
        $duration = round($endTime - $startTime, 2);
        
        $output->writeln('<info>Search index built successfully!</info>');
        $output->writeln(sprintf('<info>Indexed %d files in %s seconds</info>', count($index), $duration));
        
        return Command::SUCCESS;
    }
}
