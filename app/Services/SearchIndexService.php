<?php

namespace App\Services;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class SearchIndexService
{
    /**
     * Path to the index file
     *
     * @var string
     */
    private $indexPath;
    
    /**
     * Directory to index
     *
     * @var string
     */
    private $contentDir;
    
    /**
     * File extensions to index
     *
     * @var array
     */
    private $extensions;
    
    /**
     * Constructor
     *
     * @param string $indexPath Path to the index file
     * @param string $contentDir Directory to index
     * @param array $extensions File extensions to index
     */
    public function __construct(string $indexPath = null, string $contentDir = 'content', array $extensions = ['md'])
    {
        $this->indexPath = $indexPath ?? __DIR__ . '/../../storage/search_index.json';
        $this->contentDir = rtrim($contentDir, '/');
        $this->extensions = $extensions;
    }
    
    /**
     * Build the search index
     *
     * @return array The built index
     */
    public function buildIndex(): array
    {
        $index = [];
        $path = __DIR__ . '/../../' . $this->contentDir;
        
        if (!is_dir($path)) {
            return $index;
        }
        
        // Prepare file extensions pattern
        $pattern = '/\.(' . implode('|', $this->extensions) . ')$/i';
        
        // Get all files in directory and subdirectories
        $directory = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($directory);
        $files = new RegexIterator($iterator, $pattern);
        
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
            
            // Get file metadata
            $metadata = $this->getFileMetadata($file->getPathname(), $content);
            
            // Get file URL
            $url = $this->getFileUrl($file->getPathname());
            
            // Extract keywords from content
            $keywords = $this->extractKeywords($content);
            
            // Add to index
            $index[] = [
                'path' => $this->getRelativePath($file->getPathname()),
                'url' => $url,
                'title' => $metadata['title'],
                'content' => $this->sanitizeContent($content),
                'keywords' => $keywords,
                'modified' => $file->getMTime(),
            ];
        }
        
        // Save index to file
        $this->saveIndex($index);
        
        return $index;
    }
    
    /**
     * Save index to file
     *
     * @param array $index The index to save
     * @return bool Whether the index was saved successfully
     */
    public function saveIndex(array $index): bool
    {
        $indexDir = dirname($this->indexPath);
        
        // Create directory if it doesn't exist
        if (!is_dir($indexDir)) {
            mkdir($indexDir, 0755, true);
        }
        
        // Save index to file
        return file_put_contents($this->indexPath, json_encode($index)) !== false;
    }
    
    /**
     * Load index from file
     *
     * @return array The loaded index
     */
    public function loadIndex(): array
    {
        if (!file_exists($this->indexPath)) {
            return [];
        }
        
        $index = json_decode(file_get_contents($this->indexPath), true);
        
        return is_array($index) ? $index : [];
    }
    
    /**
     * Check if index needs to be rebuilt
     *
     * @return bool Whether the index needs to be rebuilt
     */
    public function needsRebuild(): bool
    {
        // If index doesn't exist, it needs to be built
        if (!file_exists($this->indexPath)) {
            return true;
        }
        
        // Get index modification time
        $indexMTime = filemtime($this->indexPath);
        
        // Check if any content file is newer than the index
        $path = __DIR__ . '/../../' . $this->contentDir;
        
        if (!is_dir($path)) {
            return false;
        }
        
        // Prepare file extensions pattern
        $pattern = '/\.(' . implode('|', $this->extensions) . ')$/i';
        
        // Get all files in directory and subdirectories
        $directory = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($directory);
        $files = new RegexIterator($iterator, $pattern);
        
        foreach ($files as $file) {
            // Skip directories
            if ($file->isDir()) {
                continue;
            }
            
            // If file is newer than index, index needs to be rebuilt
            if ($file->getMTime() > $indexMTime) {
                return true;
            }
        }
        
        return false;
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
     * @return string
     */
    private function getRelativePath(string $filePath): string
    {
        $basePath = __DIR__ . '/../../';
        $relativePath = str_replace($basePath, '', $filePath);
        
        return $relativePath;
    }
    
    /**
     * Get file URL from file path
     *
     * @param string $filePath File path
     * @return string
     */
    private function getFileUrl(string $filePath): string
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
     * Extract keywords from content
     *
     * @param string $content Content
     * @return array
     */
    private function extractKeywords(string $content): array
    {
        // Remove Markdown formatting
        $content = preg_replace('/[#*_`~\[\]\(\)]+/', ' ', $content);
        
        // Convert to lowercase
        $content = strtolower($content);
        
        // Split into words
        $words = preg_split('/\s+/', $content);
        
        // Filter out short words and common words
        $words = array_filter($words, function($word) {
            return strlen($word) > 3 && !in_array($word, $this->getStopWords());
        });
        
        // Count word occurrences
        $wordCounts = array_count_values($words);
        
        // Sort by count (descending)
        arsort($wordCounts);
        
        // Take top 20 words
        return array_slice(array_keys($wordCounts), 0, 20);
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
     * Sanitize content for storage
     *
     * @param string $content Content
     * @return string
     */
    private function sanitizeContent(string $content): string
    {
        // Remove Markdown formatting
        $content = preg_replace('/[#*_`~\[\]\(\)]+/', ' ', $content);
        
        // Remove extra whitespace
        $content = preg_replace('/\s+/', ' ', $content);
        
        // Trim
        $content = trim($content);
        
        // Limit length
        if (strlen($content) > 1000) {
            $content = substr($content, 0, 1000) . '...';
        }
        
        return $content;
    }
}
