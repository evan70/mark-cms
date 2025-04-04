<?php

namespace App\Services;

use OpenAI;
use OpenAI\Client;
use App\Services\ContentGeneratorInterface;

class AIContentGenerator implements ContentGeneratorInterface
{
    private $client;
    private $config;

    public function __construct(array $config = null)
    {
        $this->config = $config ?? require __DIR__ . '/../../config/openai.php';

        $this->client = OpenAI::client(
            $this->config['api_key'],
            $this->config['organization'] ? $this->config['organization'] : null
        );
    }

    /**
     * Generate content using AI
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
        if (empty($this->config['api_key'])) {
            throw new \Exception('OpenAI API key is not set. Please set OPENAI_API_KEY in your .env file.');
        }

        // Get template
        $templateConfig = $this->config['templates'][$template] ?? null;
        if (!$templateConfig) {
            throw new \InvalidArgumentException("Template '{$template}' not found");
        }

        // Prepare prompt
        $prompt = $templateConfig['prompt'];
        foreach ($parameters as $key => $value) {
            $prompt = str_replace("{{$key}}", $value, $prompt);
        }

        // Prepare options
        $model = $options['model'] ?? $this->config['default_model'];
        $temperature = $options['temperature'] ?? $this->config['temperature'];
        $maxTokens = $options['max_tokens'] ?? $this->config['max_tokens'];
        $systemMessage = $options['system_message'] ?? $templateConfig['system_message'] ?? $this->config['system_message'];

        try {
            // Generate content
            $response = $this->client->chat()->create([
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemMessage],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => $temperature,
                'max_tokens' => $maxTokens,
            ]);

            // Return content
            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            // Log error
            error_log('OpenAI API Error: ' . $e->getMessage());

            // Throw a more user-friendly error
            throw new \Exception('Error generating content: ' . $e->getMessage());
        }
    }

    /**
     * Get available templates
     *
     * @return array
     */
    public function getTemplates(): array
    {
        return $this->config['templates'];
    }

    /**
     * Get available models
     *
     * @return array
     */
    public function getModels(): array
    {
        return $this->config['models'];
    }

    /**
     * Get generator name
     *
     * @return string
     */
    public function getName(): string
    {
        return 'OpenAI';
    }
}
