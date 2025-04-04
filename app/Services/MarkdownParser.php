<?php

namespace App\Services;

use Symfony\Component\Yaml\Yaml;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownParser
{
    private $converter;

    public function __construct()
    {
        // Configure the Environment with all the CommonMark parsers/renderers
        $environment = new Environment([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());

        // Create the converter
        $this->converter = new MarkdownConverter($environment);
    }

    /**
     * Parse markdown content with frontmatter
     *
     * @param string $content
     * @return array
     */
    public function parse(string $content): array
    {
        // Extract frontmatter
        $pattern = '/^---\n(.*?)\n---\n(.*)/s';
        if (preg_match($pattern, $content, $matches)) {
            $frontmatter = Yaml::parse($matches[1]);
            $markdown = $matches[2];
        } else {
            $frontmatter = [];
            $markdown = $content;
        }

        // Convert markdown to HTML
        $html = $this->converter->convert($markdown)->getContent();

        return array_merge($frontmatter, [
            'content' => $html,
            'raw_content' => $markdown,
        ]);
    }

    /**
     * Generate markdown content with frontmatter
     *
     * @param array $frontmatter
     * @param string $content
     * @return string
     */
    public function generate(array $frontmatter, string $content): string
    {
        $yaml = Yaml::dump($frontmatter);
        return "---\n{$yaml}---\n\n{$content}";
    }
}
