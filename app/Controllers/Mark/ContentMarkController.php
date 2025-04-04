<?php

namespace App\Controllers\Mark;

use App\Controllers\BaseController;
use App\Services\ContentService;
use App\Services\FileManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ContentMarkController extends BaseController
{
    private $contentService;
    private $fileManager;

    public function __construct(\Psr\Container\ContainerInterface $container, ContentService $contentService, FileManager $fileManager)
    {
        parent::__construct($container);
        $this->contentService = $contentService;
        $this->fileManager = $fileManager;
    }

    /**
     * Display a listing of articles
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        // Get category from query parameter
        $category = $request->getQueryParams()['category'] ?? null;

        // Get articles
        $articles = $this->contentService->getArticles([], $category);

        // Get subdirectories
        $subdirectories = $this->getSubdirectories($category);

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.content.index';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.content.index-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Content Management' . ($category ? ' - ' . ucfirst($category) : ''),
            'articles' => $articles,
            'subdirectories' => $subdirectories,
            'category' => $category,
            'breadcrumbs' => $this->getBreadcrumbs($category)
        ]);
    }

    /**
     * Show the form for creating a new article
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        // Get category from query parameter
        $category = $request->getQueryParams()['category'] ?? null;

        // Get subdirectories
        $subdirectories = $this->getSubdirectories($category);

        // Get available categories
        $availableCategories = $this->getAvailableCategories();

        // Debug
        error_log('Available categories: ' . print_r($availableCategories, true));

        // Make sure we have at least some categories
        if (empty($availableCategories)) {
            $availableCategories = [
                [
                    'name' => 'Blog',
                    'path' => 'blog',
                    'value' => 'blog'
                ],
                [
                    'name' => 'Technology',
                    'path' => 'blog/technology',
                    'value' => 'blog/technology'
                ],
                [
                    'name' => 'AI',
                    'path' => 'blog/technology/ai',
                    'value' => 'blog/technology/ai'
                ],
                [
                    'name' => 'Lifestyle',
                    'path' => 'blog/lifestyle',
                    'value' => 'blog/lifestyle'
                ]
            ];
        }

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.content.create';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.content.create-side-menu';
        }

        // Check if we have AI generated content
        $aiContent = $request->getQueryParams()['ai_content'] ?? null;

        return $this->render($response, $request, $view, [
            'title' => 'Create Article' . ($category ? ' in ' . ucfirst($category) : ''),
            'category' => $category,
            'subdirectories' => $subdirectories,
            'breadcrumbs' => $this->getBreadcrumbs($category),
            'is_index' => $request->getQueryParams()['is_index'] ?? false,
            'availableCategories' => $availableCategories,
            'ai_content' => $aiContent
        ]);
    }

    /**
     * Store a newly created article
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();

        // Get category from form data
        $category = $data['category'] ?? null;

        // Handle featured image upload
        $featuredImage = null;
        if (isset($uploadedFiles['featured_image']) && $uploadedFiles['featured_image']->getError() === UPLOAD_ERR_OK) {
            $uploadedFile = $uploadedFiles['featured_image'];
            $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            $filename = bin2hex(random_bytes(8)) . '.' . $extension;
            $directory = 'public/uploads/images';

            // Create directory if it doesn't exist
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Move uploaded file
            $uploadedFile->moveTo($directory . '/' . $filename);
            $featuredImage = '/uploads/images/' . $filename;
        }

        // Generate frontmatter
        $frontmatter = [
            'title' => $data['title'],
            'slug' => $this->generateSlug($data['title']),
            'date' => date('Y-m-d'),
            'author' => $data['author'] ?? 'admin',
            'categories' => isset($data['categories']) && is_array($data['categories']) ? $data['categories'] : [],
            'tags' => array_filter(explode(',', $data['tags'] ?? '')),
            'featured_image' => $featuredImage,
            'excerpt' => $data['excerpt'] ?? '',
            'status' => $data['status'] ?? 'draft',
            'language' => $data['language'] ?? 'sk',
            'is_index' => isset($data['is_index']) && $data['is_index'] === '1'
        ];

        // Save article
        $filename = $this->contentService->saveArticle($frontmatter, $data['content'], null, $category);

        // Redirect to content list or edit page
        if ($category) {
            return $response
                ->withHeader('Location', '/mark/content?category=' . urlencode($category))
                ->withStatus(302);
        } else {
            return $response
                ->withHeader('Location', '/mark/content/' . urlencode($filename) . '/edit')
                ->withStatus(302);
        }
    }

    /**
     * Show the form for editing the specified article
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        $filename = $args['filename'];

        // Get category from query parameter
        $category = $request->getQueryParams()['category'] ?? null;

        $article = $this->contentService->getArticleByFilename($filename, $category);

        if (!$article) {
            throw new \Slim\Exception\HttpNotFoundException($request);
        }

        // Get subdirectories
        $subdirectories = $this->getSubdirectories($category);

        // Get available categories
        $availableCategories = $this->getAvailableCategories();

        // Debug
        error_log('Available categories: ' . print_r($availableCategories, true));

        // Make sure we have at least some categories
        if (empty($availableCategories)) {
            $availableCategories = [
                [
                    'name' => 'Blog',
                    'path' => 'blog',
                    'value' => 'blog'
                ],
                [
                    'name' => 'Technology',
                    'path' => 'blog/technology',
                    'value' => 'blog/technology'
                ],
                [
                    'name' => 'AI',
                    'path' => 'blog/technology/ai',
                    'value' => 'blog/technology/ai'
                ],
                [
                    'name' => 'Lifestyle',
                    'path' => 'blog/lifestyle',
                    'value' => 'blog/lifestyle'
                ]
            ];
        }

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.content.edit';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.content.edit-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Edit Article',
            'article' => $article,
            'category' => $category,
            'subdirectories' => $subdirectories,
            'breadcrumbs' => $this->getBreadcrumbs($category),
            'availableCategories' => $availableCategories
        ]);
    }

    /**
     * Update the specified article
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $filename = $args['filename'];

        // Get category from form data
        $data = $request->getParsedBody();
        $category = $data['category'] ?? null;

        $article = $this->contentService->getArticleByFilename($filename, $category);

        if (!$article) {
            throw new \Slim\Exception\HttpNotFoundException($request);
        }

        $uploadedFiles = $request->getUploadedFiles();

        // Handle featured image upload
        $featuredImage = $article['featured_image'] ?? null;
        if (isset($uploadedFiles['featured_image']) && $uploadedFiles['featured_image']->getError() === UPLOAD_ERR_OK) {
            $uploadedFile = $uploadedFiles['featured_image'];
            $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            $filename = bin2hex(random_bytes(8)) . '.' . $extension;
            $directory = 'public/uploads/images';

            // Create directory if it doesn't exist
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Move uploaded file
            $uploadedFile->moveTo($directory . '/' . $filename);
            $featuredImage = '/uploads/images/' . $filename;
        }

        // Generate frontmatter
        $frontmatter = [
            'title' => $data['title'],
            'slug' => $data['slug'] ?? $this->generateSlug($data['title']),
            'date' => $data['date'] ?? date('Y-m-d'),
            'author' => $data['author'] ?? 'admin',
            'categories' => isset($data['categories']) && is_array($data['categories']) ? $data['categories'] : [],
            'tags' => array_filter(explode(',', $data['tags'] ?? '')),
            'featured_image' => $featuredImage,
            'excerpt' => $data['excerpt'] ?? '',
            'status' => $data['status'] ?? 'draft',
            'language' => $data['language'] ?? 'sk',
            'is_index' => isset($data['is_index']) && $data['is_index'] === '1'
        ];

        // Save article
        $this->contentService->saveArticle($frontmatter, $data['content'], $args['filename'], $category);

        // Redirect to content list or edit page
        if ($category) {
            return $response
                ->withHeader('Location', '/mark/content?category=' . urlencode($category))
                ->withStatus(302);
        } else {
            return $response
                ->withHeader('Location', '/mark/content/' . urlencode($args['filename']) . '/edit')
                ->withStatus(302);
        }
    }

    /**
     * Remove the specified article
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $filename = $args['filename'];

        // Get category from query parameter
        $category = $request->getQueryParams()['category'] ?? null;

        $this->contentService->deleteArticle($filename, $category);

        // Redirect to content list
        if ($category) {
            return $response
                ->withHeader('Location', '/mark/content?category=' . urlencode($category))
                ->withStatus(302);
        } else {
            return $response
                ->withHeader('Location', '/mark/content')
                ->withStatus(302);
        }
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

    /**
     * Get subdirectories
     *
     * @param string|null $category
     * @return array
     */
    private function getSubdirectories(?string $category = null): array
    {
        // Set base directory
        $baseDir = __DIR__ . '/../../../../content';
        if ($category) {
            $baseDir .= '/' . $category;
        }

        // Check if directory exists
        if (!is_dir($baseDir)) {
            return [];
        }

        // Get subdirectories
        $subdirectories = [];
        $dirs = glob($baseDir . '/*', GLOB_ONLYDIR);
        foreach ($dirs as $dir) {
            $name = basename($dir);
            $path = $category ? $category . '/' . $name : $name;
            $subdirectories[] = [
                'name' => $name,
                'path' => $path
            ];
        }

        return $subdirectories;
    }

    /**
     * Get breadcrumbs
     *
     * @param string|null $category
     * @return array
     */
    private function getBreadcrumbs(?string $category = null): array
    {
        if (!$category) {
            return [[
                'name' => 'Content',
                'path' => null
            ]];
        }

        $breadcrumbs = [[
            'name' => 'Content',
            'path' => ''
        ]];

        $parts = explode('/', $category);
        $path = '';
        foreach ($parts as $part) {
            $path = $path ? $path . '/' . $part : $part;
            $breadcrumbs[] = [
                'name' => ucfirst($part),
                'path' => $path
            ];
        }

        return $breadcrumbs;
    }

    /**
     * Get available categories
     *
     * @return array
     */
    private function getAvailableCategories(): array
    {
        // Set base directory
        $baseDir = __DIR__ . '/../../../../content';
        error_log('Base directory: ' . $baseDir);

        // Check if directory exists
        if (!is_dir($baseDir)) {
            error_log('Base directory does not exist: ' . $baseDir);
            // Return hardcoded categories even if directory doesn't exist
            return [
                [
                    'name' => 'Blog',
                    'path' => 'blog',
                    'value' => 'blog'
                ],
                [
                    'name' => 'Technology',
                    'path' => 'blog/technology',
                    'value' => 'blog/technology'
                ],
                [
                    'name' => 'AI',
                    'path' => 'blog/technology/ai',
                    'value' => 'blog/technology/ai'
                ],
                [
                    'name' => 'Lifestyle',
                    'path' => 'blog/lifestyle',
                    'value' => 'blog/lifestyle'
                ]
            ];
        }

        // Get all directories recursively
        $directories = $this->getDirectoriesRecursively($baseDir);
        error_log('Directories: ' . print_r($directories, true));

        // Format categories
        $categories = [];
        foreach ($directories as $directory) {
            // Skip the root directory
            if ($directory === '') {
                continue;
            }

            // Add category
            $categories[] = [
                'name' => ucfirst(basename($directory)),
                'path' => $directory,
                'value' => $directory
            ];
        }

        // Always add hardcoded categories
        $hardcodedCategories = [
            [
                'name' => 'Blog',
                'path' => 'blog',
                'value' => 'blog'
            ],
            [
                'name' => 'Technology',
                'path' => 'blog/technology',
                'value' => 'blog/technology'
            ],
            [
                'name' => 'AI',
                'path' => 'blog/technology/ai',
                'value' => 'blog/technology/ai'
            ],
            [
                'name' => 'Lifestyle',
                'path' => 'blog/lifestyle',
                'value' => 'blog/lifestyle'
            ]
        ];

        // Merge with found categories
        $categories = array_merge($categories, $hardcodedCategories);

        error_log('Categories: ' . print_r($categories, true));

        return $categories;
    }

    /**
     * Get directories recursively
     *
     * @param string $baseDir
     * @param string $prefix
     * @return array
     */
    private function getDirectoriesRecursively(string $baseDir, string $prefix = ''): array
    {
        $directories = [''];

        // Get subdirectories
        $dirs = glob($baseDir . '/*', GLOB_ONLYDIR);
        error_log('Subdirectories in ' . $baseDir . ': ' . print_r($dirs, true));

        foreach ($dirs as $dir) {
            $name = basename($dir);
            $path = $prefix ? $prefix . '/' . $name : $name;
            $directories[] = $path;
            error_log('Added directory: ' . $path);

            // Get subdirectories recursively
            $subdirectories = $this->getDirectoriesRecursively($dir, $path);
            $directories = array_merge($directories, $subdirectories);
        }

        return $directories;
    }
}
