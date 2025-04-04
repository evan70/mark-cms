<?php

namespace App\Services;

class FileManager
{
    /**
     * Save file
     *
     * @param string $path
     * @param string $content
     * @return bool
     */
    public function saveFile(string $path, string $content): bool
    {
        // Create directory if it doesn't exist
        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        return file_put_contents($path, $content) !== false;
    }

    /**
     * Read file
     *
     * @param string $path
     * @return string|null
     */
    public function readFile(string $path): ?string
    {
        if (!file_exists($path)) {
            return null;
        }
        
        return file_get_contents($path);
    }

    /**
     * Delete file
     *
     * @param string $path
     * @return bool
     */
    public function deleteFile(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        return unlink($path);
    }

    /**
     * List files in directory
     *
     * @param string $directory
     * @param string $pattern
     * @return array
     */
    public function listFiles(string $directory, string $pattern = '*'): array
    {
        if (!is_dir($directory)) {
            return [];
        }
        
        $files = glob($directory . '/' . $pattern);
        
        return array_map(function($file) use ($directory) {
            return str_replace($directory . '/', '', $file);
        }, $files);
    }

    /**
     * Upload file
     *
     * @param array $file
     * @param string $directory
     * @param string|null $filename
     * @return string|null
     */
    public function uploadFile(array $file, string $directory, ?string $filename = null): ?string
    {
        // Check if file is valid
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return null;
        }
        
        // Create directory if it doesn't exist
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Generate filename if not provided
        if (!$filename) {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = bin2hex(random_bytes(8)) . '.' . $extension;
        }
        
        // Move uploaded file
        $path = $directory . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            return null;
        }
        
        return $filename;
    }
}
