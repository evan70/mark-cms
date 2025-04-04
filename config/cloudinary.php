<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for Cloudinary.
    |
    */

    'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'] ?? null,
    'api_key' => $_ENV['CLOUDINARY_API_KEY'] ?? null,
    'api_secret' => $_ENV['CLOUDINARY_API_SECRET'] ?? null,
    'url' => $_ENV['CLOUDINARY_URL'] ?? null,
    
    // Default folder for uploads
    'upload_folder' => 'mark-cms',
    
    // Default transformations for images
    'default_transformations' => [
        'quality' => 'auto',
        'fetch_format' => 'auto',
    ],
    
    // Image sizes
    'sizes' => [
        'thumbnail' => [
            'width' => 150,
            'height' => 150,
            'crop' => 'fill',
        ],
        'small' => [
            'width' => 300,
            'height' => 200,
            'crop' => 'fill',
        ],
        'medium' => [
            'width' => 600,
            'height' => 400,
            'crop' => 'fill',
        ],
        'large' => [
            'width' => 1200,
            'height' => 800,
            'crop' => 'fill',
        ],
    ],
];
