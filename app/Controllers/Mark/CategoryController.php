<?php

namespace App\Controllers\Mark;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use App\Models\Category;

class CategoryController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response): Response
    {
        $categories = Category::with('translations')->get();
        
        $view = $this->container->get('view');
        $view->share([
            'categories' => $categories,
            'title' => 'Manage Categories'
        ]);
        
        $response->getBody()->write(
            $view->make('admin.categories.index')->render()
        );
        
        return $response;
    }

    public function create(Request $request, Response $response): Response
    {
        $view = $this->container->get('view');
        $view->share(['title' => 'Create Category']);
        
        $response->getBody()->write(
            $view->make('admin.categories.create')->render()
        );
        
        return $response;
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        
        $category = new Category();
        $category->slug = \Str::slug($data['name_en']);
        $category->save();
        
        // Save translations
        foreach (['en', 'sk', 'cs'] as $locale) {
            $category->translations()->create([
                'locale' => $locale,
                'name' => $data["name_${locale}"],
                'description' => $data["description_${locale}"] ?? null
            ]);
        }
        
        return $response
            ->withHeader('Location', '/admin/categories')
            ->withStatus(302);
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $category = Category::with('translations')->findOrFail($args['id']);
        
        $view = $this->container->get('view');
        $view->share([
            'category' => $category,
            'title' => 'Edit Category'
        ]);
        
        $response->getBody()->write(
            $view->make('admin.categories.edit')->render()
        );
        
        return $response;
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $category = Category::findOrFail($args['id']);
        
        $category->slug = \Str::slug($data['name_en']);
        $category->save();
        
        // Update translations
        foreach (['en', 'sk', 'cs'] as $locale) {
            $category->translations()
                ->where('locale', $locale)
                ->update([
                    'name' => $data["name_${locale}"],
                    'description' => $data["description_${locale}"] ?? null
                ]);
        }
        
        return $response
            ->withHeader('Location', '/admin/categories')
            ->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $category = Category::findOrFail($args['id']);
        $category->delete();
        
        return $response
            ->withHeader('Location', '/admin/categories')
            ->withStatus(302);
    }
}
