<?php

namespace App\Services;

class ContentGeneratorFactory
{
    /**
     * Create content generator
     *
     * @param string $type Generator type (openai, deepseek, fake)
     * @return ContentGeneratorInterface
     */
    public static function create(string $type): ContentGeneratorInterface
    {
        switch ($type) {
            case 'openai':
                return new AIContentGenerator();
            case 'deepseek':
                return new DeepseekContentGenerator();
            case 'fake':
            default:
                return new FakeContentGenerator();
        }
    }
    
    /**
     * Get available generators
     *
     * @return array
     */
    public static function getAvailableGenerators(): array
    {
        return [
            'openai' => 'OpenAI',
            'deepseek' => 'Deepseek',
            'fake' => 'Fake Generator',
        ];
    }
}
