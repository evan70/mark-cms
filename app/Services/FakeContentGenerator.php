<?php

namespace App\Services;

use App\Services\ContentGeneratorInterface;

class FakeContentGenerator implements ContentGeneratorInterface
{
    /**
     * Generate fake content
     *
     * @param string $template Template name
     * @param array $parameters Template parameters
     * @param array $options Additional options
     * @return string
     */
    public function generateContent(string $template, array $parameters = [], array $options = []): string
    {
        // Get template name from parameters
        $templateName = $template;

        // Generate content based on template
        switch ($templateName) {
            case 'article':
                return $this->generateArticle($parameters);
            case 'product_description':
                return $this->generateProductDescription($parameters);
            case 'seo_meta':
                return $this->generateSeoMeta($parameters);
            default:
                return $this->generateGenericContent($parameters);
        }
    }

    /**
     * Generate fake article
     *
     * @param array $parameters
     * @return string
     */
    private function generateArticle(array $parameters): string
    {
        $topic = $parameters['topic'] ?? 'Technology';
        $section1 = $parameters['section1'] ?? 'Introduction';
        $section2 = $parameters['section2'] ?? 'Main Content';
        $section3 = $parameters['section3'] ?? 'Conclusion';

        return "# {$topic}: A Comprehensive Guide\n\n" .
               "## Introduction\n\n" .
               "Welcome to our comprehensive guide on {$topic}. In this article, we'll explore the key aspects of {$topic} and how it impacts our daily lives.\n\n" .
               "## {$section1}\n\n" .
               "The {$section1} of {$topic} is a fascinating area to explore. It encompasses various elements that contribute to the overall understanding of the subject.\n\n" .
               "- Key point 1 about {$section1}\n" .
               "- Key point 2 about {$section1}\n" .
               "- Key point 3 about {$section1}\n\n" .
               "## {$section2}\n\n" .
               "When it comes to {$section2}, there are several important factors to consider. These factors play a crucial role in shaping the landscape of {$topic}.\n\n" .
               "1. First aspect of {$section2}\n" .
               "2. Second aspect of {$section2}\n" .
               "3. Third aspect of {$section2}\n\n" .
               "## {$section3}\n\n" .
               "The {$section3} phase of {$topic} brings everything together. It's important to understand how all the elements interact and influence each other.\n\n" .
               "## Conclusion\n\n" .
               "In conclusion, {$topic} is a multifaceted subject that requires a deep understanding of {$section1}, {$section2}, and {$section3}. By mastering these areas, you'll be well-equipped to navigate the complexities of {$topic} in today's rapidly evolving landscape.";
    }

    /**
     * Generate fake product description
     *
     * @param array $parameters
     * @return string
     */
    private function generateProductDescription(array $parameters): string
    {
        $productName = $parameters['product_name'] ?? 'Product';

        return "# {$productName}: The Ultimate Solution\n\n" .
               "## Product Overview\n\n" .
               "Introducing the revolutionary {$productName} - designed to transform the way you work and live. This cutting-edge product combines innovative technology with sleek design to deliver an unparalleled user experience.\n\n" .
               "## Key Features and Benefits\n\n" .
               "- **Advanced Technology**: Utilizing the latest advancements in the industry\n" .
               "- **User-Friendly Interface**: Intuitive controls for seamless operation\n" .
               "- **Durable Construction**: Built to last with premium materials\n" .
               "- **Energy Efficient**: Reduces consumption while maximizing performance\n\n" .
               "## Technical Specifications\n\n" .
               "- Dimensions: 10\" x 5\" x 2\"\n" .
               "- Weight: 1.5 lbs\n" .
               "- Battery Life: Up to 10 hours\n" .
               "- Connectivity: Bluetooth 5.0, Wi-Fi\n\n" .
               "## Ideal Use Cases\n\n" .
               "The {$productName} is perfect for professionals, students, and anyone seeking to enhance their productivity. Whether you're working from home, studying at a café, or traveling for business, this product adapts to your lifestyle.\n\n" .
               "## What Sets It Apart\n\n" .
               "Unlike competitors, the {$productName} offers a unique combination of performance, reliability, and value. Our proprietary technology ensures a smoother experience, while our commitment to quality guarantees long-term satisfaction.";
    }

    /**
     * Generate fake SEO meta description
     *
     * @param array $parameters
     * @return string
     */
    private function generateSeoMeta(array $parameters): string
    {
        $topic = $parameters['topic'] ?? 'Product';

        return "Discover everything you need to know about {$topic}. Our comprehensive guide covers key features, benefits, and expert tips to help you make informed decisions. Learn more today!";
    }

    /**
     * Generate generic fake content
     *
     * @param array $parameters
     * @return string
     */
    private function generateGenericContent(array $parameters): string
    {
        $keys = array_keys($parameters);
        $firstParam = !empty($keys) ? $parameters[$keys[0]] : 'Content';

        return "# Generated Content About {$firstParam}\n\n" .
               "This is automatically generated content based on your parameters. In a real implementation, this would be generated by an AI model like GPT-3.5 or GPT-4.\n\n" .
               "## Parameters Received\n\n" .
               implode("\n", array_map(function($key, $value) {
                   return "- **{$key}**: {$value}";
               }, array_keys($parameters), $parameters)) . "\n\n" .
               "## Sample Content\n\n" .
               "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies aliquam, nunc nisl aliquet nunc, vitae aliquam nisl nunc vitae nisl. Nullam auctor, nisl eget ultricies aliquam, nunc nisl aliquet nunc, vitae aliquam nisl nunc vitae nisl.\n\n" .
               "### Subsection\n\n" .
               "- Point 1\n" .
               "- Point 2\n" .
               "- Point 3\n\n" .
               "## Conclusion\n\n" .
               "Thank you for using our content generator. This is a placeholder that would normally be replaced with AI-generated content.";
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
                'system_message' => 'You are a professional content writer.',
                'prompt' => "Write a comprehensive blog article about {topic}.",
                'parameters' => ['topic', 'section1', 'section2', 'section3'],
            ],
            'product_description' => [
                'name' => 'Product Description',
                'system_message' => 'You are a professional copywriter.',
                'prompt' => "Write a persuasive product description for {product_name}.",
                'parameters' => ['product_name'],
            ],
            'seo_meta' => [
                'name' => 'SEO Meta Description',
                'system_message' => 'You are an SEO specialist.',
                'prompt' => "Write an SEO-optimized meta description for a page about {topic}.",
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
            'fake-model' => 'Fake Model (No API Call)',
        ];
    }

    /**
     * Get generator name
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Fake Generator';
    }
}
