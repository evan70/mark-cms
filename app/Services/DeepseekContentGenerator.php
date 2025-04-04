<?php

namespace App\Services;

use App\Services\ContentGeneratorInterface;
use GuzzleHttp\Client;

class DeepseekContentGenerator implements ContentGeneratorInterface
{
    private $client;
    private $apiKey;
    
    public function __construct(string $apiKey = null)
    {
        $this->apiKey = $apiKey ?? $_ENV['DEEPSEEK_API_KEY'] ?? '';
        $this->client = new Client([
            'base_uri' => 'https://api.deepseek.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }
    
    /**
     * Generate content using Deepseek API
     *
     * @param string $template Template name
     * @param array $parameters Template parameters
     * @param array $options Additional options
     * @return string
     * @throws \Exception If an error occurs during content generation
     */
    public function generateContent(string $template, array $parameters = [], array $options = []): string
    {
        // Check if API key is set
        if (empty($this->apiKey)) {
            throw new \Exception('Deepseek API key is not set. Please set DEEPSEEK_API_KEY in your .env file.');
        }
        
        // Get template config
        $templateConfig = $this->getTemplates()[$template] ?? null;
        if (!$templateConfig) {
            throw new \InvalidArgumentException("Template '{$template}' not found");
        }
        
        // Prepare prompt
        $prompt = $templateConfig['prompt'];
        foreach ($parameters as $key => $value) {
            $prompt = str_replace("{{$key}}", $value, $prompt);
        }
        
        // Prepare options
        $model = $options['model'] ?? 'deepseek-chat';
        $temperature = $options['temperature'] ?? 0.7;
        $maxTokens = $options['max_tokens'] ?? 1000;
        $systemMessage = $options['system_message'] ?? $templateConfig['system_message'] ?? 'You are a helpful assistant.';
        
        try {
            // Call Deepseek API
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemMessage],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => $temperature,
                    'max_tokens' => $maxTokens,
                ],
            ]);
            
            // Parse response
            $result = json_decode($response->getBody()->getContents(), true);
            
            // Return content
            return $result['choices'][0]['message']['content'] ?? 'No content generated';
        } catch (\Exception $e) {
            // If API call fails, use fake content generator as fallback
            error_log('Deepseek API Error: ' . $e->getMessage());
            
            // Use fake content generator
            $fakeGenerator = new FakeContentGenerator();
            return "# Deepseek API Error\n\nThere was an error calling the Deepseek API: " . $e->getMessage() . "\n\n## Fallback Content\n\n" . 
                   $fakeGenerator->generateContent($template, $parameters, $options);
        }
    }
    
    /**
     * Get available templates
     *
     * @return array
     */
    public function getTemplates(): array
    {
        return [
            'article' => [
                'name' => 'Blog Article',
                'system_message' => 'You are a professional content writer. Create a well-structured, informative blog article with headings, subheadings, and bullet points where appropriate.',
                'prompt' => "Write a comprehensive blog article about {topic}. Include the following sections:\n\n1. Introduction\n2. {section1}\n3. {section2}\n4. {section3}\n5. Conclusion\n\nMake the article approximately 800-1200 words. Use Markdown formatting.",
                'parameters' => ['topic', 'section1', 'section2', 'section3'],
            ],
            'product_description' => [
                'name' => 'Product Description',
                'system_message' => 'You are a professional copywriter specializing in product descriptions. Create compelling, benefit-focused product descriptions that convert browsers into buyers.',
                'prompt' => "Write a persuasive product description for {product_name}. Include:\n\n- Key features and benefits\n- Technical specifications\n- Ideal use cases\n- What sets it apart from competitors\n\nMake the description approximately 300-500 words. Use Markdown formatting.",
                'parameters' => ['product_name'],
            ],
            'seo_meta' => [
                'name' => 'SEO Meta Description',
                'system_message' => 'You are an SEO specialist. Create compelling meta descriptions that improve click-through rates from search results.',
                'prompt' => "Write an SEO-optimized meta description for a page about {topic}. The meta description should be 150-160 characters, include the main keyword, and entice users to click through from search results.",
                'parameters' => ['topic'],
            ],
        ];
    }
    
    /**
     * Get available models
     *
     * @return array
     */
    public function getModels(): array
    {
        return [
            'deepseek-chat' => 'Deepseek Chat',
            'deepseek-coder' => 'Deepseek Coder',
        ];
    }
    
    /**
     * Get generator name
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Deepseek';
    }
}
