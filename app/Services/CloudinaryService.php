<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\Exception\ApiError;
use Cloudinary\Asset\Media;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Tag\ImageTag;
use Cloudinary\Transformation\Resize;
use Cloudinary\Transformation\Gravity;
use Cloudinary\Transformation\Quality;
use Cloudinary\Transformation\Format;
use Cloudinary\Transformation\Delivery;
use Psr\Http\Message\UploadedFileInterface;

class CloudinaryService
{
    /**
     * Cloudinary instance
     *
     * @var Cloudinary
     */
    private $cloudinary;

    /**
     * Configuration
     *
     * @var array
     */
    private $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/cloudinary.php';

        // Configure Cloudinary
        if ($this->config['url']) {
            // Configure from URL
            $this->cloudinary = new Cloudinary($this->config['url']);
        } else {
            // Configure from individual settings
            $this->cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => $this->config['cloud_name'],
                    'api_key' => $this->config['api_key'],
                    'api_secret' => $this->config['api_secret'],
                ],
            ]);
        }
    }

    /**
     * Upload an image
     *
     * @param UploadedFileInterface|string $file File to upload (can be a PSR-7 uploaded file or a file path)
     * @param array $options Upload options
     * @return array|null Upload result or null on failure
     */
    public function upload($file, array $options = []): ?array
    {
        try {
            // Set default options
            $options = array_merge([
                'folder' => $this->config['upload_folder'],
                'resource_type' => 'image',
                'overwrite' => true,
                'unique_filename' => true,
            ], $options);

            // Create upload directory if it doesn't exist
            $uploadDir = __DIR__ . '/../../public/uploads/' . $options['folder'];
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $filename = uniqid() . '_' . time();

            // Handle PSR-7 uploaded file
            if ($file instanceof UploadedFileInterface) {
                // Get file extension
                $originalFilename = $file->getClientFilename();
                $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
                $filename .= '.' . $extension;

                // Move uploaded file
                $file->moveTo($uploadDir . '/' . $filename);
            } else {
                // Copy file
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $filename .= '.' . $extension;
                copy($file, $uploadDir . '/' . $filename);
            }

            // Get file info
            $filePath = $uploadDir . '/' . $filename;
            $fileSize = filesize($filePath);
            $fileType = mime_content_type($filePath);

            // Get image dimensions
            $imageSize = getimagesize($filePath);
            $width = $imageSize[0] ?? 0;
            $height = $imageSize[1] ?? 0;

            // Create result
            $publicId = $options['folder'] . '/' . $filename;
            $url = '/uploads/' . $publicId;

            $result = [
                'public_id' => $publicId,
                'url' => $url,
                'secure_url' => $url,
                'width' => $width,
                'height' => $height,
                'format' => $extension,
                'resource_type' => 'image',
                'created_at' => date('Y-m-d H:i:s'),
                'bytes' => $fileSize,
                'type' => 'upload',
                'etag' => md5_file($filePath),
                'placeholder' => false,
                'original_filename' => $file instanceof UploadedFileInterface ? $file->getClientFilename() : basename($file),
            ];

            return $result;
        } catch (\Exception $e) {
            // Log error
            error_log('Upload error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get image URL with transformations
     *
     * @param string $publicId Public ID of the image
     * @param string $size Size of the image (thumbnail, small, medium, large)
     * @param array $options Additional options
     * @return string Image URL
     */
    public function getImageUrl(string $publicId, string $size = 'medium', array $options = []): string
    {
        // Get size configuration
        $sizeConfig = $this->config['sizes'][$size] ?? $this->config['sizes']['medium'];

        // Set default options
        $options = array_merge([
            'width' => $sizeConfig['width'],
            'height' => $sizeConfig['height'],
            'crop' => $sizeConfig['crop'],
            'quality' => $this->config['default_transformations']['quality'],
            'fetch_format' => $this->config['default_transformations']['fetch_format'],
        ], $options);

        // Build transformation
        $transformation = [];

        // Add crop transformation
        if (isset($options['width']) && isset($options['height']) && isset($options['crop'])) {
            $transformation[] = [
                'width' => $options['width'],
                'height' => $options['height'],
                'crop' => $options['crop'],
            ];
        }

        // Add quality transformation
        if (isset($options['quality'])) {
            $transformation[] = ['quality' => $options['quality']];
        }

        // Add format transformation
        if (isset($options['fetch_format'])) {
            $transformation[] = ['fetch_format' => $options['fetch_format']];
        }

        // Generate URL
        return $this->cloudinary->image($publicId)
            ->resize(Resize::fill($options['width'], $options['height']))
            ->delivery(Delivery::quality(Quality::auto()))
            ->delivery(Delivery::format(Format::auto()))
            ->toUrl();
    }

    /**
     * Get image tag with transformations
     *
     * @param string $publicId Public ID of the image
     * @param string $size Size of the image (thumbnail, small, medium, large)
     * @param array $options Additional options
     * @return string Image tag
     */
    public function getImageTag(string $publicId, string $size = 'medium', array $options = []): string
    {
        // Get size configuration
        $sizeConfig = $this->config['sizes'][$size] ?? $this->config['sizes']['medium'];

        // Set default options
        $options = array_merge([
            'width' => $sizeConfig['width'],
            'height' => $sizeConfig['height'],
            'crop' => $sizeConfig['crop'],
            'quality' => $this->config['default_transformations']['quality'],
            'fetch_format' => $this->config['default_transformations']['fetch_format'],
            'alt' => '',
            'class' => '',
        ], $options);

        // Generate image tag
        $tag = $this->cloudinary->image($publicId)
            ->resize(Resize::fill($options['width'], $options['height']))
            ->delivery(Delivery::quality(Quality::auto()))
            ->delivery(Delivery::format(Format::auto()));

        // Add HTML attributes
        $tag->setAttribute('alt', $options['alt']);

        if (!empty($options['class'])) {
            $tag->setAttribute('class', $options['class']);
        }

        return $tag->toTag();
    }

    /**
     * Delete an image
     *
     * @param string $publicId Public ID of the image
     * @return bool Success
     */
    public function delete(string $publicId): bool
    {
        try {
            // Get file path
            $filePath = __DIR__ . '/../../public/uploads/' . $publicId;

            // Check if file exists
            if (!file_exists($filePath)) {
                return false;
            }

            // Delete file
            unlink($filePath);

            return true;
        } catch (\Exception $e) {
            // Log error
            error_log('Delete error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * List images
     *
     * @param array $options List options
     * @return array|null List result or null on failure
     */
    public function listImages(array $options = []): ?array
    {
        try {
            // Set default options
            $options = array_merge([
                'type' => 'upload',
                'prefix' => $this->config['upload_folder'] . '/',
                'max_results' => 100,
            ], $options);

            // Get folder from prefix
            $folder = rtrim($options['prefix'], '/');
            $folder = basename($folder);

            // Get upload directory
            $uploadDir = __DIR__ . '/../../public/uploads/' . $folder;

            // Check if directory exists
            if (!is_dir($uploadDir)) {
                return ['resources' => [], 'next_cursor' => null];
            }

            // Get all files in directory
            $files = scandir($uploadDir);
            $resources = [];

            foreach ($files as $file) {
                // Skip . and ..
                if ($file === '.' || $file === '..') {
                    continue;
                }

                // Skip directories
                if (is_dir($uploadDir . '/' . $file)) {
                    continue;
                }

                // Get file info
                $filePath = $uploadDir . '/' . $file;
                $fileSize = filesize($filePath);
                $fileType = mime_content_type($filePath);

                // Skip non-image files
                if (strpos($fileType, 'image/') !== 0) {
                    continue;
                }

                // Get image dimensions
                $imageSize = getimagesize($filePath);
                $width = $imageSize[0] ?? 0;
                $height = $imageSize[1] ?? 0;

                // Create resource
                $publicId = $folder . '/' . $file;
                $url = '/uploads/' . $publicId;

                $resources[] = [
                    'public_id' => $publicId,
                    'url' => $url,
                    'secure_url' => $url,
                    'width' => $width,
                    'height' => $height,
                    'format' => pathinfo($file, PATHINFO_EXTENSION),
                    'resource_type' => 'image',
                    'created_at' => date('Y-m-d H:i:s', filemtime($filePath)),
                    'bytes' => $fileSize,
                    'type' => 'upload',
                    'etag' => md5_file($filePath),
                    'placeholder' => false,
                ];
            }

            // Sort resources by created_at (newest first)
            usort($resources, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            // Limit results
            if (isset($options['max_results']) && count($resources) > $options['max_results']) {
                $resources = array_slice($resources, 0, $options['max_results']);
            }

            return [
                'resources' => $resources,
                'next_cursor' => null, // No pagination for local files
            ];
        } catch (\Exception $e) {
            // Log error
            error_log('List images error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Format upload result
     *
     * @param ApiResponse $result Upload result
     * @return array Formatted result
     */
    private function formatUploadResult(ApiResponse $result): array
    {
        return [
            'public_id' => $result['public_id'],
            'url' => $result['secure_url'],
            'width' => $result['width'],
            'height' => $result['height'],
            'format' => $result['format'],
            'resource_type' => $result['resource_type'],
            'created_at' => $result['created_at'],
            'bytes' => $result['bytes'],
            'type' => $result['type'],
            'etag' => $result['etag'],
            'placeholder' => $result['placeholder'] ?? false,
            'original_filename' => $result['original_filename'],
        ];
    }

    /**
     * Format list result
     *
     * @param ApiResponse $result List result
     * @return array Formatted result
     */
    private function formatListResult(ApiResponse $result): array
    {
        $resources = [];

        foreach ($result['resources'] as $resource) {
            $resources[] = [
                'public_id' => $resource['public_id'],
                'url' => $resource['secure_url'],
                'width' => $resource['width'],
                'height' => $resource['height'],
                'format' => $resource['format'],
                'resource_type' => $resource['resource_type'],
                'created_at' => $resource['created_at'],
                'bytes' => $resource['bytes'],
                'type' => $resource['type'],
                'etag' => $resource['etag'],
                'placeholder' => $resource['placeholder'] ?? false,
            ];
        }

        return [
            'resources' => $resources,
            'next_cursor' => $result['next_cursor'] ?? null,
            'rate_limit_allowed' => $result['rate_limit_allowed'] ?? null,
            'rate_limit_reset_at' => $result['rate_limit_reset_at'] ?? null,
            'rate_limit_remaining' => $result['rate_limit_remaining'] ?? null,
        ];
    }
}
