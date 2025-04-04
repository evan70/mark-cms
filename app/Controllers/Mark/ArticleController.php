<?php

namespace App\Controllers\Mark;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Controllers\BaseController;
use Carbon\Carbon;

class ArticleController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        $articles = Article::with('translations')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.articles.index';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.articles.index-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Articles',
            'articles' => $articles
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        $categories = Category::with('translations')->where('is_active', true)->get();
        $tags = Tag::with('translations')->get();
        $languages = ['en', 'sk', 'cs']; // Available languages

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.articles.create';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.articles.create-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Create Article',
            'categories' => $categories,
            'tags' => $tags,
            'languages' => $languages
        ]);
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();

        // Create article
        $article = Article::create([
            'slug' => $this->createSlug($data['title_en']),
            'is_published' => isset($data['is_published']),
            'published_at' => isset($data['is_published']) ? Carbon::now() : null,
            'featured_image' => $this->handleFeaturedImage($uploadedFiles['featured_image'] ?? null)
        ]);

        // Create translations
        foreach (['en', 'sk', 'cs'] as $locale) {
            if (!empty($data["title_{$locale}"])) {
                $article->translations()->create([
                    'locale' => $locale,
                    'title' => $data["title_{$locale}"],
                    'content' => $data["content_{$locale}"] ?? '',
                    'meta_title' => $data["meta_title_{$locale}"] ?? '',
                    'meta_description' => $data["meta_description_{$locale}"] ?? '',
                    'meta_keywords' => $data["meta_keywords_{$locale}"] ?? ''
                ]);
            }
        }

        // Attach categories
        if (isset($data['categories']) && is_array($data['categories'])) {
            $article->categories()->attach($data['categories']);
        }

        // Attach tags
        if (isset($data['tags']) && is_array($data['tags'])) {
            $article->tags()->attach($data['tags']);
        }

        // Redirect to edit page
        return $response
            ->withHeader('Location', '/mark/articles/' . $article->id . '/edit')
            ->withStatus(302);
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $article = Article::with(['translations', 'categories', 'tags'])->findOrFail($args['id']);
        $categories = Category::with('translations')->where('is_active', true)->get();
        $tags = Tag::with('translations')->get();
        $languages = ['en', 'sk', 'cs']; // Available languages

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.articles.edit';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.articles.edit-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Edit Article',
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags,
            'languages' => $languages
        ]);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $article = Article::findOrFail($args['id']);
        $data = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();

        // Update article
        $article->update([
            'slug' => $this->createSlug($data['title_en'], $article->id),
            'is_published' => isset($data['is_published']),
            'published_at' => isset($data['is_published']) ? ($article->published_at ?? Carbon::now()) : null,
            'featured_image' => $this->handleFeaturedImage($uploadedFiles['featured_image'] ?? null, $article->featured_image)
        ]);

        // Update translations
        foreach (['en', 'sk', 'cs'] as $locale) {
            if (!empty($data["title_{$locale}"])) {
                $article->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'title' => $data["title_{$locale}"],
                        'content' => $data["content_{$locale}"] ?? '',
                        'meta_title' => $data["meta_title_{$locale}"] ?? '',
                        'meta_description' => $data["meta_description_{$locale}"] ?? '',
                        'meta_keywords' => $data["meta_keywords_{$locale}"] ?? ''
                    ]
                );
            }
        }

        // Sync categories
        $article->categories()->sync($data['categories'] ?? []);

        // Sync tags
        $article->tags()->sync($data['tags'] ?? []);

        // Redirect back to edit page
        return $response
            ->withHeader('Location', '/mark/articles/' . $article->id . '/edit')
            ->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $article = Article::findOrFail($args['id']);

        // Delete translations
        $article->translations()->delete();

        // Detach categories and tags
        $article->categories()->detach();
        $article->tags()->detach();

        // Delete article
        $article->delete();

        // Redirect to articles list
        return $response
            ->withHeader('Location', '/mark/articles')
            ->withStatus(302);
    }

    private function createSlug(string $title, int $excludeId = null): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $count = 1;

        $query = Article::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            $query = Article::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    private function handleFeaturedImage($uploadedFile, string $currentImage = null): ?string
    {
        if (!$uploadedFile) {
            return $currentImage;
        }

        $directory = 'uploads/articles';
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $filename = bin2hex(random_bytes(8)) . '.' . $extension;

        // Create directory if it doesn't exist
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Move uploaded file
        $uploadedFile->moveTo($directory . '/' . $filename);

        // Delete old file if exists
        if ($currentImage && file_exists($currentImage)) {
            unlink($currentImage);
        }

        return $directory . '/' . $filename;
    }
}
