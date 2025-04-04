<?php

namespace App\Services;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use App\Services\SearchIndexService;

class SearchService
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
        $this->indexService = $indexService ?? new SearchIndexService();
    }

    /**
     * Search for content in Markdown files
     *
     * @param string $query Search query
     * @param string $directory Directory to search in
     * @param array $extensions File extensions to search in
     * @param int $limit Maximum number of results
     * @return array
     */
    public function search(string $query, string $directory = 'content', array $extensions = ['md'], int $limit = 10): array
    {
        $results = [];
        $query = trim($query);

        if (empty($query) || strlen($query) < 3) {
            return $results;
        }

        // Check if index needs to be rebuilt
        if ($this->indexService->needsRebuild()) {
            $this->indexService->buildIndex();
        }

        // Load index
        $index = $this->indexService->loadIndex();

        // If index is empty, fall back to direct search
        if (empty($index)) {
            return $this->searchWithoutIndex($query, $directory, $extensions, $limit);
        }

        // Search in index
        $queryWords = $this->tokenizeQuery($query);

        foreach ($index as $item) {
            $score = $this->calculateScore($item, $queryWords);

            if ($score > 0) {
                $results[] = [
                    'title' => $item['title'],
                    'path' => $item['path'],
                    'url' => $item['url'],
                    'excerpt' => $this->getExcerpt($item['content'], $query),
                    'relevance' => $score,
                ];
            }
        }

        // Sort results by relevance
        usort($results, function($a, $b) {
            return $b['relevance'] <=> $a['relevance'];
        });

        // Limit results
        return array_slice($results, 0, $limit);
    }

    /**
     * Search without using index
     *
     * @param string $query Search query
     * @param string $directory Directory to search in
     * @param array $extensions File extensions to search in
     * @param int $limit Maximum number of results
     * @return array
     */
    private function searchWithoutIndex(string $query, string $directory = 'content', array $extensions = ['md'], int $limit = 10): array
    {
        $results = [];

        // Prepare directory path
        $directory = rtrim($directory, '/');
        $path = __DIR__ . '/../../' . $directory;

        if (!is_dir($path)) {
            return $results;
        }

        // Prepare file extensions pattern
        $pattern = '/\.(' . implode('|', $extensions) . ')$/i';

        // Get all files in directory and subdirectories
        $directory = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($directory);
        $files = new RegexIterator($iterator, $pattern);

        // Search in files
        foreach ($files as $file) {
            // Skip directories
            if ($file->isDir()) {
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
                // Get file metadata
                $metadata = $this->getFileMetadata($file->getPathname(), $content);

                // Add to results
                $results[] = [
                    'title' => $metadata['title'],
                    'path' => $this->getRelativePath($file->getPathname(), $directory),
                    'url' => $this->getFileUrl($file->getPathname(), $directory),
                    'excerpt' => $this->getExcerpt($content, $query),
                    'relevance' => $this->calculateRelevance($content, $query),
                ];

                // Limit results
                if (count($results) >= $limit) {
                    break;
                }
            }
        }

        // Sort results by relevance
        usort($results, function($a, $b) {
            return $b['relevance'] <=> $a['relevance'];
        });

        return $results;
    }

    /**
     * Get file metadata from content
     *
     * @param string $filePath File path
     * @param string $content File content
     * @return array
     */
    private function getFileMetadata(string $filePath, string $content): array
    {
        $metadata = [
            'title' => basename($filePath, '.md'),
        ];

        // Try to extract title from content
        if (preg_match('/^#\s+(.+)$/m', $content, $matches)) {
            $metadata['title'] = $matches[1];
        }

        return $metadata;
    }

    /**
     * Get relative path from absolute path
     *
     * @param string $filePath Absolute file path
     * @param string $directory Base directory
     * @return string
     */
    private function getRelativePath(string $filePath, string $directory): string
    {
        $basePath = __DIR__ . '/../../';
        $relativePath = str_replace($basePath, '', $filePath);

        return $relativePath;
    }

    /**
     * Get file URL from file path
     *
     * @param string $filePath File path
     * @param string $directory Base directory
     * @return string
     */
    private function getFileUrl(string $filePath, string $directory): string
    {
        $basePath = __DIR__ . '/../../';
        $relativePath = str_replace($basePath, '', $filePath);

        // Remove file extension
        $url = preg_replace('/\.md$/', '', $relativePath);

        // Remove 'content/' prefix
        $url = preg_replace('/^content\//', '', $url);

        // Handle index files
        $url = preg_replace('/\/index$/', '', $url);

        return '/' . $url;
    }

    /**
     * Get excerpt from content
     *
     * @param string $content Content
     * @param string $query Search query
     * @param int $length Excerpt length
     * @return string
     */
    private function getExcerpt(string $content, string $query, int $length = 150): string
    {
        // Remove Markdown formatting
        $content = preg_replace('/[#*_`~\[\]\(\)]+/', '', $content);

        // Find position of query
        $pos = stripos($content, $query);

        if ($pos === false) {
            // If query not found, return beginning of content
            return substr($content, 0, $length) . '...';
        }

        // Calculate start position
        $start = max(0, $pos - floor(($length - strlen($query)) / 2));

        // Get excerpt
        $excerpt = substr($content, $start, $length);

        // Add ellipsis if needed
        if ($start > 0) {
            $excerpt = '...' . $excerpt;
        }

        if ($start + $length < strlen($content)) {
            $excerpt .= '...';
        }

        // Highlight query
        $excerpt = preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', $excerpt);

        return $excerpt;
    }

    /**
     * Tokenize query into words
     *
     * @param string $query Search query
     * @return array
     */
    private function tokenizeQuery(string $query): array
    {
        // Convert to lowercase
        $query = strtolower($query);

        // Split into words
        $words = preg_split('/\s+/', $query);

        // Filter out short words and common words
        $words = array_filter($words, function($word) {
            return strlen($word) > 2 && !in_array($word, $this->getStopWords());
        });

        return array_values($words);
    }

    /**
     * Calculate score for an item based on query words
     *
     * @param array $item Index item
     * @param array $queryWords Query words
     * @return float
     */
    private function calculateScore(array $item, array $queryWords): float
    {
        $score = 0;
        $content = strtolower($item['content']);
        $title = strtolower($item['title']);

        // Check each query word
        foreach ($queryWords as $word) {
            // Check if word is in title
            if (strpos($title, $word) !== false) {
                $score += 10;
            }

            // Check if word is in content
            if (strpos($content, $word) !== false) {
                $score += 1;

                // Count occurrences
                $occurrences = substr_count($content, $word);
                $score += min($occurrences / 10, 2); // Cap at 2 points
            }

            // Check if word is in keywords
            if (in_array($word, $item['keywords'])) {
                $score += 5;
            }
        }

        // Bonus for exact phrase match
        $phrase = implode(' ', $queryWords);
        if (strpos($content, $phrase) !== false) {
            $score += 5;
        }

        return $score;
    }

    /**
     * Get stop words (common words to exclude from keywords)
     *
     * @return array
     */
    private function getStopWords(): array
    {
        return [
            'the', 'and', 'that', 'have', 'for', 'not', 'with', 'you', 'this', 'but',
            'his', 'from', 'they', 'she', 'will', 'would', 'there', 'their', 'what',
            'about', 'which', 'when', 'make', 'like', 'time', 'just', 'him', 'know',
            'take', 'people', 'into', 'year', 'your', 'good', 'some', 'could', 'them',
            'see', 'other', 'than', 'then', 'now', 'look', 'only', 'come', 'its', 'over',
            'think', 'also', 'back', 'after', 'use', 'two', 'how', 'our', 'work', 'first',
            'well', 'way', 'even', 'new', 'want', 'because', 'any', 'these', 'give', 'day',
            'most', 'can', 'are', 'was', 'has', 'had', 'been', 'were', 'did', 'does', 'doing',
            'should', 'could', 'would', 'might', 'must', 'shall', 'will', 'may', 'can',
        ];
    }

    /**
     * Calculate relevance score (for non-indexed search)
     *
     * @param string $content Content
     * @param string $query Search query
     * @return float
     */
    private function calculateRelevance(string $content, string $query): float
    {
        $relevance = 0;

        // Count occurrences
        $occurrences = substr_count(strtolower($content), strtolower($query));
        $relevance += $occurrences;

        // Check if query is in title
        if (preg_match('/^#\s+.*' . preg_quote($query, '/') . '.*$/im', $content)) {
            $relevance += 10;
        }

        // Check if query is in headings
        if (preg_match('/^#{2,6}\s+.*' . preg_quote($query, '/') . '.*$/im', $content)) {
            $relevance += 5;
        }

        return $relevance;
    }
}
