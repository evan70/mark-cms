<?php

namespace App\Controllers\Mark;

use App\Controllers\BaseController;
use App\Services\ContentGeneratorInterface;
use App\Services\ContentGeneratorFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AIContentController extends BaseController
{
    private $contentGenerator;

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        parent::__construct($container);
        // Default to fake generator
        $this->contentGenerator = ContentGeneratorFactory::create('fake');
    }

    /**
     * Display the AI content generator form
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        // Get generator type from query parameter or session
        $generatorType = $request->getQueryParams()['generator'] ?? $_SESSION['generator_type'] ?? 'fake';
        $_SESSION['generator_type'] = $generatorType;

        // Create content generator
        $this->contentGenerator = ContentGeneratorFactory::create($generatorType);

        // Get available templates
        $templates = $this->contentGenerator->getTemplates();

        // Get available models
        $models = $this->contentGenerator->getModels();

        // Get available generators
        $generators = ContentGeneratorFactory::getAvailableGenerators();

        // Get generated content from session
        $generatedContent = $_SESSION['generated_content'] ?? null;
        unset($_SESSION['generated_content']); // Clear after use

        // Get error message from session
        $errorMessage = $_SESSION['error_message'] ?? null;
        unset($_SESSION['error_message']); // Clear after use

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.ai-content.index';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.ai-content.index-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'AI Content Generator',
            'templates' => $templates,
            'models' => $models,
            'generators' => $generators,
            'currentGenerator' => $generatorType,
            'generatorName' => $this->contentGenerator->getName(),
            'generatedContent' => $generatedContent,
            'errorMessage' => $errorMessage,
        ]);
    }

    /**
     * Generate content using AI
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function generate(Request $request, Response $response): Response
    {
        $parsedBody = $request->getParsedBody();

        // Validate input
        if (!isset($parsedBody['template'])) {
            $_SESSION['error_message'] = 'Template is required';
            return $response->withHeader('Location', '/mark/ai-content')->withStatus(302);
        }

        // Prepare parameters
        $parameters = [];
        foreach ($parsedBody as $key => $value) {
            if (strpos($key, 'param_') === 0) {
                $paramName = substr($key, 6); // Remove 'param_' prefix
                $parameters[$paramName] = $value;
            }
        }

        // Prepare options
        $options = [
            'model' => $parsedBody['model'] ?? null,
            'temperature' => isset($parsedBody['temperature']) ? (float) $parsedBody['temperature'] : null,
            'max_tokens' => isset($parsedBody['max_tokens']) ? (int) $parsedBody['max_tokens'] : null,
        ];

        // Get generator type from form or session
        $generatorType = $parsedBody['generator'] ?? $_SESSION['generator_type'] ?? 'fake';
        $_SESSION['generator_type'] = $generatorType;

        // Create content generator
        $this->contentGenerator = ContentGeneratorFactory::create($generatorType);

        // Generate content
        try {
            $content = $this->contentGenerator->generateContent(
                $parsedBody['template'],
                $parameters,
                $options
            );

            // Store generated content in session
            $_SESSION['generated_content'] = $content;

            // Redirect back to the form
            return $response->withHeader('Location', '/mark/ai-content')->withStatus(302);
        } catch (\Exception $e) {
            // Store error message in session
            $_SESSION['error_message'] = $e->getMessage();

            // Redirect back to the form
            return $response->withHeader('Location', '/mark/ai-content')->withStatus(302);
        }
    }
}
