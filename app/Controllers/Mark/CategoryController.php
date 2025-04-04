<?php

namespace App\Controllers\Mark;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Category;
use App\Controllers\BaseController;

class CategoryController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        $categories = Category::with('translations')->get();

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.categories.index';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.categories.index-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Categories',
            'categories' => $categories
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        $languages = ['en', 'sk', 'cs']; // Available languages

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.categories.create';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.categories.create-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Create Category',
            'languages' => $languages
        ]);
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        // Create category
        $category = Category::create([
            'slug' => $this->createSlug($data['name_en']),
            'is_active' => isset($data['is_active'])
        ]);

        // Create translations
        foreach (['en', 'sk', 'cs'] as $locale) {
            if (!empty($data["name_{$locale}"])) {
                $category->translations()->create([
                    'locale' => $locale,
                    'name' => $data["name_{$locale}"],
                    'description' => $data["description_{$locale}"] ?? ''
                ]);
            }
        }

        // Redirect to categories list
        return $response
            ->withHeader('Location', '/mark/categories')
            ->withStatus(302);
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $category = Category::with('translations')->findOrFail($args['id']);
        $languages = ['en', 'sk', 'cs']; // Available languages

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.categories.edit';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.categories.edit-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Edit Category',
            'category' => $category,
            'languages' => $languages
        ]);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $category = Category::findOrFail($args['id']);
        $data = $request->getParsedBody();

        // Update category
        $category->update([
            'slug' => $this->createSlug($data['name_en'], $category->id),
            'is_active' => isset($data['is_active'])
        ]);

        // Update translations
        foreach (['en', 'sk', 'cs'] as $locale) {
            if (!empty($data["name_{$locale}"])) {
                $category->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'name' => $data["name_{$locale}"],
                        'description' => $data["description_{$locale}"] ?? ''
                    ]
                );
            }
        }

        // Redirect to categories list
        return $response
            ->withHeader('Location', '/mark/categories')
            ->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $category = Category::findOrFail($args['id']);

        // Check if category has articles
        if ($category->articles()->count() > 0) {
            // Set flash message
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Cannot delete category with articles. Remove articles first.'
            ];

            // Redirect back to categories list
            return $response
                ->withHeader('Location', '/mark/categories')
                ->withStatus(302);
        }

        // Delete translations
        $category->translations()->delete();

        // Delete category
        $category->delete();

        // Set flash message
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Category deleted successfully.'
        ];

        // Redirect to categories list
        return $response
            ->withHeader('Location', '/mark/categories')
            ->withStatus(302);
    }

    private function createSlug(string $name, int $excludeId = null): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $originalSlug = $slug;
        $count = 1;

        $query = Category::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            $query = Category::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }
}
