<?php

// Simple search script for Markdown files

// Get search query
$query = $_GET['q'] ?? '';
$results = [];

if (!empty($query) && strlen($query) >= 3) {
    // Search in content directory
    $directory = __DIR__ . '/../content';

    if (is_dir($directory)) {
        // Get all Markdown files
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $file) {
            // Skip directories and non-Markdown files
            if ($file->isDir() || $file->getExtension() !== 'md') {
                continue;
            }

            // Get file content
            $content = file_get_contents($file->getPathname());

            // Skip empty files
            if (empty($content)) {
                continue;
            }

            // Check if query is in content
            if (stripos($content, $query) !== false) {
                // Extract title from content
                $title = basename($file->getPathname(), '.md');
                if (preg_match('/^#\s+(.+)$/m', $content, $matches)) {
                    $title = $matches[1];
                }

                // Get excerpt
                $pos = stripos($content, $query);
                $start = max(0, $pos - 50);
                $excerpt = substr($content, $start, 150);
                if ($start > 0) {
                    $excerpt = '...' . $excerpt;
                }
                if ($start + 150 < strlen($content)) {
                    $excerpt .= '...';
                }

                // Highlight query
                $excerpt = preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', $excerpt);

                // Add to results
                $results[] = [
                    'title' => $title,
                    'path' => str_replace($directory, '', $file->getPathname()),
                    'url' => '/' . str_replace(['.md', $directory . '/'], ['', ''], $file->getPathname()),
                    'excerpt' => $excerpt,
                ];
            }
        }
    }
}

// Sort results by title
usort($results, function($a, $b) {
    return strcmp($a['title'], $b['title']);
});

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="/css/app.css" rel="stylesheet">
    <style>
        mark {
            background-color: rgba(124, 58, 237, 0.3);
            color: #f3f4f6;
            padding: 0 2px;
            border-radius: 2px;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6">Search Results</h1>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET" class="mb-8">
                <div class="flex">
                    <input type="text"
                           name="q"
                           value="<?= htmlspecialchars($query) ?>"
                           placeholder="Search..."
                           class="flex-grow px-4 py-2 rounded-l-md bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <button type="submit"
                            class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        Search
                    </button>
                </div>
            </form>

            <?php if (empty($query)): ?>
                <div class="text-center py-8">
                    <p class="text-gray-400">Enter a search term to find content.</p>
                </div>
            <?php elseif (empty($results)): ?>
                <div class="text-center py-8">
                    <p class="text-gray-400">No results found for "<?= htmlspecialchars($query) ?>".</p>
                    <p class="mt-4 text-gray-500">Try different keywords or check your spelling.</p>
                </div>
            <?php else: ?>
                <p class="mb-4 text-gray-400">Found <?= count($results) ?> results for "<?= htmlspecialchars($query) ?>"</p>

                <div class="space-y-6">
                    <?php foreach ($results as $result): ?>
                        <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-750 transition-colors">
                            <a href="<?= htmlspecialchars($result['url']) ?>" class="block">
                                <h2 class="text-xl font-semibold text-purple-400 mb-2"><?= htmlspecialchars($result['title']) ?></h2>
                                <p class="text-gray-300 mb-2"><?= $result['excerpt'] ?></p>
                                <p class="text-gray-500 text-sm"><?= htmlspecialchars($result['url']) ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
