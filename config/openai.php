<?php

return [
    // OpenAI API key
    'api_key' => $_ENV['OPENAI_API_KEY'] ?? '',
    
    // OpenAI organization ID (optional)
    'organization' => $_ENV['OPENAI_ORGANIZATION'] ?? '',
    
    // Default model to use
    'default_model' => 'gpt-3.5-turbo',
    
    // Available models
    'models' => [
        'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
        'gpt-4' => 'GPT-4',
    ],
    
    // Default temperature (0.0 - 1.0)
    'temperature' => 0.7,
    
    // Default max tokens
    'max_tokens' => 1000,
    
    // Default system message
    'system_message' => 'You are a helpful assistant that generates high-quality content for a blog.',
    
    // Content templates
    'templates' => [
        'article' => [
            'name' => 'Blog Article',
            'system_message' => 'You are a professional content writer. Create a well-structured, informative blog article with headings, subheadings, and bullet points where appropriate. The content should be engaging, factually accurate, and optimized for SEO.',
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
    ],
];
