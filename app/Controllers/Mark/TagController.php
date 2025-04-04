<?php

namespace App\Controllers\Mark;

use App\Models\Tag;
use App\Models\TagTranslation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class TagController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        $tags = Tag::with('translations')->get();

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.tags.index';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.tags.index-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Tags',
            'tags' => $tags
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        $languages = ['en', 'sk', 'cs']; // Available languages

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.tags.create';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.tags.create-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Create Tag',
            'languages' => $languages
        ]);
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        // Create tag
        $tag = Tag::create([
            'slug' => $this->createSlug($data['name_en'])
        ]);

        // Create translations
        foreach (['en', 'sk', 'cs'] as $locale) {
            if (!empty($data["name_{$locale}"])) {
                $tag->translations()->create([
                    'locale' => $locale,
                    'name' => $data["name_{$locale}"]
                ]);
            }
        }

        // Redirect to tags list
        return $response
            ->withHeader('Location', '/mark/tags')
            ->withStatus(302);
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $tag = Tag::with('translations')->findOrFail($args['id']);
        $languages = ['en', 'sk', 'cs']; // Available languages

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.tags.edit';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.tags.edit-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Edit Tag',
            'tag' => $tag,
            'languages' => $languages
        ]);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $tag = Tag::findOrFail($args['id']);
        $data = $request->getParsedBody();

        // Update tag
        $tag->update([
            'slug' => $this->createSlug($data['name_en'], $tag->id)
        ]);

        // Update translations
        foreach (['en', 'sk', 'cs'] as $locale) {
            if (!empty($data["name_{$locale}"])) {
                $tag->translations()->updateOrCreate(
                    ['locale' => $locale],
                    ['name' => $data["name_{$locale}"]]
                );
            }
        }

        // Redirect to tags list
        return $response
            ->withHeader('Location', '/mark/tags')
            ->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $tag = Tag::findOrFail($args['id']);

        // Check if tag has articles
        if ($tag->articles()->count() > 0) {
            // Set flash message
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Cannot delete tag with articles. Remove articles first.'
            ];

            // Redirect back to tags list
            return $response
                ->withHeader('Location', '/mark/tags')
                ->withStatus(302);
        }

        // Delete tag (will also delete translations due to cascade delete in model)
        $tag->delete();

        // Set flash message
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Tag deleted successfully.'
        ];

        // Redirect to tags list
        return $response
            ->withHeader('Location', '/mark/tags')
            ->withStatus(302);
    }

    private function createSlug(string $name, int $excludeId = null): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $originalSlug = $slug;
        $count = 1;

        $query = Tag::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            $query = Tag::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }
}
