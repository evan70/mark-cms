<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use voku\helper\HtmlMin;
use Slim\Psr7\Stream;

class HtmlCompressorMiddleware implements MiddlewareInterface
{
    private HtmlMin $htmlMin;
    
    public function __construct()
    {
        $this->htmlMin = new HtmlMin();
        
        // Configure minifier with recommended settings
        $this->htmlMin->doRemoveComments()
            ->doSumUpWhitespace()
            ->doRemoveWhitespaceAroundTags()
            ->doOptimizeAttributes()
            ->doRemoveHttpPrefixFromAttributes()
            ->doRemoveDefaultAttributes()
            ->doRemoveDeprecatedAnchorName()
            ->doRemoveDeprecatedScriptCharsetAttribute()
            ->doRemoveDeprecatedTypeFromScriptTag()
            ->doRemoveDeprecatedTypeFromStylesheetLink()
            ->doRemoveEmptyAttributes()
            ->doRemoveValueFromEmptyInput();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        
        // Only process HTML responses
        $contentType = $response->getHeaderLine('Content-Type');
        if (strpos($contentType, 'text/html') === false) {
            return $response;
        }

        try {
            // Get response content
            $body = (string) $response->getBody();
            
            // Skip minification for empty responses
            if (empty(trim($body))) {
                return $response;
            }
            
            // Minify HTML
            $minified = $this->htmlMin->minify($body);
            
            // Create new stream
            $stream = fopen('php://temp', 'r+');
            if ($stream === false) {
                throw new \RuntimeException('Failed to create temporary stream');
            }
            
            fwrite($stream, $minified);
            rewind($stream);
            
            // Return response with minified content
            return $response
                ->withBody(new Stream($stream))
                ->withHeader('X-HTML-Compressed', 'true')
                ->withHeader('Content-Length', strlen($minified));
                
        } catch (\Throwable $e) {
            // Log error but return original response
            error_log('HTML minification failed: ' . $e->getMessage());
            return $response;
        }
    }
}
