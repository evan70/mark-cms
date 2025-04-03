<?php

namespace App\Services;

use App\Models\Article;

class ArticleLinkService
{
    /**
     * Generate a properly formatted link to an article
     *
     * @param Article $article The article to link to
     * @param string $language The current language code
     * @param array $options Additional options for the link
     * @return array Link data including URL, title, and aria attributes
     */
    public function generateArticleLink(Article $article, string $language, array $options = []): array
    {
        // Get the article translation for the current language
        $translation = $article->translations->first();

        // Default options
        $defaults = [
            'class' => 'text-purple-400 hover:text-purple-300',
            'linkText' => $translation ? $translation->title : 'Article',
            'showDate' => false,
            'showReadMore' => false,
            'dateClass' => 'text-sm text-gray-150',
        ];

        // Merge provided options with defaults
        $options = array_merge($defaults, $options);

        // Generate the URL
        $url = "/{$language}/article/{$article->slug}";

        // Generate the title and aria-label
        $title = $translation ? $translation->title : 'Article';
        $ariaLabel = __('Read article') . ': ' . $title;

        // Return the link data
        return [
            'url' => $url,
            'title' => $title,
            'ariaLabel' => $ariaLabel,
            'class' => $options['class'],
            'linkText' => $options['linkText'],
            'showDate' => $options['showDate'],
            'showReadMore' => $options['showReadMore'],
            'dateClass' => $options['dateClass'],
            'date' => $article->published_at ? $article->published_at->format('d.m.Y') : '',
        ];
    }

    /**
     * Generate HTML for an article link
     *
     * @param Article $article The article to link to
     * @param string $language The current language code
     * @param array $options Additional options for the link
     * @return string HTML for the link
     */
    public function renderArticleLink(Article $article, string $language, array $options = []): string
    {
        $linkData = $this->generateArticleLink($article, $language, $options);

        $html = '<a href="' . $linkData['url'] . '" ';
        $html .= 'class="' . $linkData['class'] . '" ';
        $html .= 'title="' . $linkData['title'] . '" ';
        $html .= 'aria-label="' . $linkData['ariaLabel'] . '">';

        if ($linkData['showReadMore']) {
            $html .= '<span>' . __('Read More') . '</span>';
            $html .= '<svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">';
            $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>';
            $html .= '</svg>';
        } else {
            $html .= $linkData['linkText'];
        }

        $html .= '</a>';

        if ($linkData['showDate']) {
            $html .= '<span class="' . $linkData['dateClass'] . '">' . $linkData['date'] . '</span>';
        }

        return $html;
    }
}
