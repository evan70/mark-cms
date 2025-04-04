<?php

namespace App\Services;

use Symfony\Component\Finder\Finder;

class ContentService
{
    private $contentPath;
    private $markdownParser;

    public function __construct(string $contentPath, MarkdownParser $markdownParser)
    {
        $this->contentPath = $contentPath;
        $this->markdownParser = $markdownParser;
    }

    /**
     * Get all articles
     *
     * @param array $filters
     * @param string|null $category Path to category (e.g. 'blog/technology/ai')
     * @return array
     */
    public function getArticles(array $filters = [], ?string $category = null): array
    {
        $finder = new Finder();

        // Set base directory
        $baseDir = $this->contentPath;
        if ($category) {
            $baseDir .= '/' . $category;
        }

        // Check if directory exists
        if (!is_dir($baseDir)) {
            return [];
        }

        // Find all markdown files in the directory and subdirectories
        $finder->files()->in($baseDir)->name('*.md')->sortByName();

        // Exclude index.md files if not explicitly requested
        if (!isset($filters['is_index']) || !$filters['is_index']) {
            $finder->notName('index.md');
        }

        $articles = [];
        foreach ($finder as $file) {
            $content = $file->getContents();
            $article = $this->markdownParser->parse($content);

            // Set filename and path information
            $article['filename'] = $file->getRelativePathname();
            $article['path'] = $category ? $category . '/' . $file->getRelativePathname() : $file->getRelativePathname();
            $article['directory'] = $file->getRelativePath();
            $article['is_index'] = $file->getFilename() === 'index.md';

            // Set category based on directory structure
            if (!isset($article['category']) && $file->getRelativePath()) {
                $article['category'] = str_replace('/', '-', $file->getRelativePath());
            }

            // Apply filters
            if (!empty($filters)) {
                $match = true;
                foreach ($filters as $key => $value) {
                    if (!isset($article[$key]) || $article[$key] !== $value) {
                        $match = false;
                        break;
                    }
                }
                if (!$match) {
                    continue;
                }
            }

            $articles[] = $article;
        }

        // Sort by date (newest first)
        usort($articles, function($a, $b) {
            // Index files should always come first
            if ($a['is_index'] && !$b['is_index']) {
                return -1;
            }
            if (!$a['is_index'] && $b['is_index']) {
                return 1;
            }

            // Then sort by date
            return strtotime($b['date'] ?? '0') - strtotime($a['date'] ?? '0');
        });

        return $articles;
    }

    /**
     * Get article by slug
     *
     * @param string $slug
     * @param string|null $category Path to category (e.g. 'blog/technology/ai')
     * @return array|null
     */
    public function getArticle(string $slug, ?string $category = null): ?array
    {
        $finder = new Finder();

        // Set base directory
        $baseDir = $this->contentPath;
        if ($category) {
            $baseDir .= '/' . $category;
        }

        // Check if directory exists
        if (!is_dir($baseDir)) {
            return null;
        }

        // Find all markdown files in the directory and subdirectories
        $finder->files()->in($baseDir)->name('*.md');

        foreach ($finder as $file) {
            $content = $file->getContents();
            $article = $this->markdownParser->parse($content);

            // Set filename and path information
            $article['filename'] = $file->getRelativePathname();
            $article['path'] = $category ? $category . '/' . $file->getRelativePathname() : $file->getRelativePathname();
            $article['directory'] = $file->getRelativePath();
            $article['is_index'] = $file->getFilename() === 'index.md';

            // Set category based on directory structure
            if (!isset($article['category']) && $file->getRelativePath()) {
                $article['category'] = str_replace('/', '-', $file->getRelativePath());
            }

            if (($article['slug'] ?? '') === $slug) {
                return $article;
            }
        }

        return null;
    }

    /**
     * Get article by filename
     *
     * @param string $filename
     * @param string|null $category Path to category (e.g. 'blog/technology/ai')
     * @return array|null
     */
    public function getArticleByFilename(string $filename, ?string $category = null): ?array
    {
        // Set base directory
        $baseDir = $this->contentPath;
        if ($category) {
            $baseDir .= '/' . $category;
        }

        $path = $baseDir . '/' . $filename;

        if (!file_exists($path)) {
            return null;
        }

        $content = file_get_contents($path);
        $article = $this->markdownParser->parse($content);

        // Set filename and path information
        $article['filename'] = $filename;
        $article['path'] = $category ? $category . '/' . $filename : $filename;
        $article['directory'] = $category ?? '';
        $article['is_index'] = basename($filename) === 'index.md';

        // Set category based on directory structure
        if (!isset($article['category']) && $category) {
            $article['category'] = str_replace('/', '-', $category);
        }

        return $article;
    }

    /**
     * Save article
     *
     * @param array $frontmatter
     * @param string $content
     * @param string|null $filename
     * @param string|null $category Path to category (e.g. 'blog/technology/ai')
     * @return string
     */
    public function saveArticle(array $frontmatter, string $content, ?string $filename = null, ?string $category = null): string
    {
        // Generate filename if not provided
        if (!$filename) {
            // If this is an index file
            if (isset($frontmatter['is_index']) && $frontmatter['is_index']) {
                $filename = "index.md";
            } else {
                $date = date('Y-m-d');
                $slug = $frontmatter['slug'] ?? $this->generateSlug($frontmatter['title'] ?? 'article');
                $filename = "{$date}-{$slug}.md";
            }
        }

        // Generate full content
        $fullContent = $this->markdownParser->generate($frontmatter, $content);

        // Set base directory
        $baseDir = $this->contentPath;
        if ($category) {
            $baseDir .= '/' . $category;

            // Create directory if it doesn't exist
            if (!is_dir($baseDir)) {
                mkdir($baseDir, 0755, true);
            }
        }

        // Save file
        $path = $baseDir . '/' . $filename;
        file_put_contents($path, $fullContent);

        return $filename;
    }

    /**
     * Delete article
     *
     * @param string $filename
     * @param string|null $category Path to category (e.g. 'blog/technology/ai')
     * @return bool
     */
    public function deleteArticle(string $filename, ?string $category = null): bool
    {
        // Set base directory
        $baseDir = $this->contentPath;
        if ($category) {
            $baseDir .= '/' . $category;
        }

        $path = $baseDir . '/' . $filename;

        if (!file_exists($path)) {
            return false;
        }

        return unlink($path);
    }

    /**
     * Generate slug from title
     *
     * @param string $title
     * @return string
     */
    private function generateSlug(string $title): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }
}
