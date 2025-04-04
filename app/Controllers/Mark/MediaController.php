<?php

namespace App\Controllers\Mark;

use App\Controllers\BaseController;
use App\Services\CloudinaryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class MediaController extends BaseController
{
    /**
     * Cloudinary service
     *
     * @var CloudinaryService
     */
    private $cloudinaryService;

    /**
     * Constructor
     *
     * @param \Psr\Container\ContainerInterface $container
     * @param CloudinaryService $cloudinaryService
     */
    public function __construct(\Psr\Container\ContainerInterface $container, CloudinaryService $cloudinaryService)
    {
        parent::__construct($container);
        $this->cloudinaryService = $cloudinaryService;
    }

    /**
     * Display media library
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        // Get images
        $images = $this->cloudinaryService->listImages();

        return $this->render($response, $request, 'mark.media.index', [
            'title' => 'Media Library',
            'images' => $images['resources'] ?? [],
            'next_cursor' => $images['next_cursor'] ?? null,
        ]);
    }

    /**
     * Display upload form
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        return $this->render($response, $request, 'mark.media.create', [
            'title' => 'Upload Media',
        ]);
    }

    /**
     * Upload media
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function store(Request $request, Response $response): Response
    {
        // Get uploaded files
        $uploadedFiles = $request->getUploadedFiles();

        if (empty($uploadedFiles['file'])) {
            throw new HttpBadRequestException($request, 'No file uploaded');
        }

        $uploadedFile = $uploadedFiles['file'];

        // Check if file is valid
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            throw new HttpBadRequestException($request, 'Upload failed');
        }

        // Get form data
        $data = $request->getParsedBody();
        $folder = $data['folder'] ?? 'mark-cms';
        $tags = $data['tags'] ?? '';

        // Upload file
        $result = $this->cloudinaryService->upload($uploadedFile, [
            'folder' => $folder,
            'tags' => $tags,
        ]);

        if (!$result) {
            throw new HttpBadRequestException($request, 'Upload failed');
        }

        // Store success message in session
        $_SESSION['success_message'] = 'Media uploaded successfully';

        // Redirect to media library
        return $response->withHeader('Location', '/mark/media')
                        ->withStatus(302);
    }

    /**
     * Display media details
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $publicId = $args['id'];

        // Check if publicId contains a slash
        if (strpos($publicId, '/') !== false) {
            // This is a path like 'mark-cms/image.jpg', redirect to preview
            $parts = explode('/', $publicId, 2);
            $folder = $parts[0];
            $filename = $parts[1];

            return $response->withHeader('Location', '/mark/media/' . $folder . '/' . $filename)
                            ->withStatus(302);
        }

        // Get images
        $images = $this->cloudinaryService->listImages([
            'public_ids' => [$publicId],
        ]);

        if (empty($images['resources'])) {
            throw new HttpNotFoundException($request, 'Media not found');
        }

        $image = $images['resources'][0];

        return $this->render($response, $request, 'mark.media.show', [
            'title' => 'Media Details',
            'image' => $image,
        ]);
    }

    /**
     * Delete media
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $publicId = $args['id'];

        // Check if this is a filename or a full path
        if (!strpos($publicId, '/')) {
            // This is just a filename, prepend the default folder
            $publicId = 'mark-cms/' . $publicId;
        }

        // Delete image
        $result = $this->cloudinaryService->delete($publicId);

        if (!$result) {
            throw new HttpBadRequestException($request, 'Delete failed');
        }

        // Store success message in session
        $_SESSION['success_message'] = 'Media deleted successfully';

        // Get redirect URL from request
        $redirect = $request->getParsedBody()['redirect'] ?? '/mark/media';

        // Redirect to media library or specified URL
        return $response->withHeader('Location', $redirect)
                        ->withStatus(302);
    }

    /**
     * API: Upload media
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function apiUpload(Request $request, Response $response): Response
    {
        // Skip CSRF check for API endpoints
        // The SkipCsrfMiddleware should handle this
        // Get uploaded files
        $uploadedFiles = $request->getUploadedFiles();

        if (empty($uploadedFiles['file'])) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'No file uploaded',
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $uploadedFile = $uploadedFiles['file'];

        // Check if file is valid
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Upload failed',
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Get form data
        $data = $request->getParsedBody();
        $folder = $data['folder'] ?? 'mark-cms';
        $tags = $data['tags'] ?? '';

        // Upload file
        $result = $this->cloudinaryService->upload($uploadedFile, [
            'folder' => $folder,
            'tags' => $tags,
        ]);

        if (!$result) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Upload failed',
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $response->getBody()->write(json_encode([
            'success' => true,
            'message' => 'Media uploaded successfully',
            'data' => $result,
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Display full-screen preview of media
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function preview(Request $request, Response $response, array $args): Response
    {
        $folder = $args['folder'] ?? 'mark-cms';
        $filename = $args['filename'] ?? '';

        // Build public ID
        $publicId = $folder . '/' . $filename;

        // Get image
        $filePath = __DIR__ . '/../../../public/uploads/' . $publicId;

        // Check if file exists
        if (!file_exists($filePath)) {
            throw new HttpNotFoundException($request, 'Media not found');
        }

        return $this->render($response, $request, 'mark.media.preview', [
            'title' => 'Media Preview',
            'image' => [
                'public_id' => $publicId,
                'url' => '/uploads/' . $publicId,
                'filename' => $filename,
            ],
        ]);
    }

    /**
     * API: List media
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function apiList(Request $request, Response $response): Response
    {
        // Get query parameters
        $params = $request->getQueryParams();
        $nextCursor = $params['next_cursor'] ?? null;
        $maxResults = $params['max_results'] ?? 100;

        // Get images
        $images = $this->cloudinaryService->listImages([
            'next_cursor' => $nextCursor,
            'max_results' => $maxResults,
        ]);

        if (!$images) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Failed to list media',
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $images,
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
