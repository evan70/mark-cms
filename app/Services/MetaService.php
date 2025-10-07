<?php

namespace App\Services;

class MetaService
{
    /**
     * Generate meta description and keywords based on title if not provided
     *
     * @param array $data
     * @return array
     */
    public function generateMeta(array $data): array
    {
        if (!isset($data['metaDescription']) && isset($data['title'])) {
            $data['metaDescription'] = $data['title'] . ' - ' . config('app.description');
        }

        if (!isset($data['metaKeywords']) && isset($data['title'])) {
            $titleWords = preg_replace('/[^a-zA-Z0-9\s]/', '', $data['title']);
            $titleKeywords = strtolower(str_replace(' ', ', ', $titleWords));
            $data['metaKeywords'] = $titleKeywords . ', ' . config('app.meta_keywords');
        }

        return $data;
    }
}
