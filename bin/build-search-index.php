<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Services\SearchIndexService;

// Create search index service
$indexService = new SearchIndexService();

// Build index
echo "Building search index...\n";
$startTime = microtime(true);
$index = $indexService->buildIndex();
$endTime = microtime(true);
$duration = round($endTime - $startTime, 2);

echo "Search index built successfully!\n";
echo sprintf("Indexed %d files in %s seconds\n", count($index), $duration);
