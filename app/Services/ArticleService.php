<?php

namespace App\Services;

use App\Models\Article;
use Carbon\Carbon;

class ArticleService
{
    private $markdownParser;

    public function __construct(MarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    /**
     * Get prepared article data for detail view
     *
     * @param string $slug
     * @param string $language
     * @return array|null
     * @throws \Slim\Exception\HttpNotFoundException
     */
    public function getArticleData(string $slug, string $language): ?array
    {
        $article = Article::with(['translations' => function($query) use ($language) {
            $query->where('locale', $language);
        }])
        ->whereHas('translations', function($query) use ($language, $slug) {
            $query->where('locale', $language)
                  ->where('slug', $slug);
        })
        ->where('is_published', true)
        ->where('published_at', '<=', Carbon::now())
        ->first();

        if (!$article) {
            return null;
        }

        $translation = $article->translations->first();

        return [
            'article' => $article,
            'title' => $translation?->title ?? 'Article',
            'metaDescription' => $translation?->meta_description ?? $translation?->perex ?? '',
            'metaKeywords' => $translation?->meta_keywords ?? '',
            'content' => $translation ? $this->markdownParser->parse($translation->content)['content'] : ''
        ];
    }
}
