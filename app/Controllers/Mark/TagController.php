<?php

namespace App\Controllers\Mark;

use App\Models\Tag;
use App\Models\TagTranslation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

class TagController
{
    public function index(Request $request, Response $response): Response
    {
        $tags = Tag::with('translations')->get();
        
        return $response->withJson([
            'data' => $tags
        ]);
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $validator = v::key('slug', v::slug())
                     ->key('translations', v::arrayVal()->each(
                         v::key('locale', v::stringType()->notEmpty())
                          ->key('name', v::stringType()->notEmpty())
                     ));

        if (!$validator->validate($data)) {
            return $response->withStatus(400)->withJson([
                'error' => 'Invalid input data'
            ]);
        }

        $tag = Tag::create([
            'slug' => $data['slug']
        ]);

        foreach ($data['translations'] as $translation) {
            TagTranslation::create([
                'tag_id' => $tag->id,
                'locale' => $translation['locale'],
                'name' => $translation['name']
            ]);
        }

        return $response->withStatus(201)->withJson([
            'data' => $tag->load('translations')
        ]);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $tag = Tag::with('translations')->find($args['id']);
        
        if (!$tag) {
            return $response->withStatus(404)->withJson([
                'error' => 'Tag not found'
            ]);
        }

        return $response->withJson([
            'data' => $tag
        ]);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $tag = Tag::find($args['id']);
        
        if (!$tag) {
            return $response->withStatus(404)->withJson([
                'error' => 'Tag not found'
            ]);
        }

        $data = $request->getParsedBody();

        if (isset($data['slug'])) {
            $tag->update(['slug' => $data['slug']]);
        }

        if (isset($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $tag->translations()
                    ->updateOrCreate(
                        ['locale' => $translation['locale']],
                        ['name' => $translation['name']]
                    );
            }
        }

        return $response->withJson([
            'data' => $tag->load('translations')
        ]);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $tag = Tag::find($args['id']);
        
        if (!$tag) {
            return $response->withStatus(404)->withJson([
                'error' => 'Tag not found'
            ]);
        }

        $tag->delete();

        return $response->withStatus(204);
    }
}
