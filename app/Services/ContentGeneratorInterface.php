<?php

namespace App\Services;

interface ContentGeneratorInterface
{
    /**
     * Generate content
     *
     * @param string $template Template name
     * @param array $parameters Template parameters
     * @param array $options Additional options
     * @return string
     */
    public function generateContent(string $template, array $parameters = [], array $options = []): string;
    
    /**
     * Get available templates
     *
     * @return array
     */
    public function getTemplates(): array;
    
    /**
     * Get available models
     *
     * @return array
     */
    public function getModels(): array;
    
    /**
     * Get generator name
     *
     * @return string
     */
    public function getName(): string;
}
