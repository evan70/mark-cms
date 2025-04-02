<?php

$images = [
    'welcome.jpg' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=800&q=80',
    'ai-2024.jpg' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&q=80',
    'javascript.jpg' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?w=800&q=80',
    'php82.jpg' => 'https://images.unsplash.com/photo-1599507593499-a3f7d7d97667?w=800&q=80',
    'digital-marketing.jpg' => 'https://images.unsplash.com/photo-1533750516457-a7f992034fec?w=800&q=80',
    'web-dev.jpg' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&q=80'
];

if (!file_exists(__DIR__ . '/../public/uploads')) {
    mkdir(__DIR__ . '/../public/uploads', 0755, true);
}

foreach ($images as $filename => $url) {
    $destination = __DIR__ . '/../public/uploads/' . $filename;
    
    if (!file_exists($destination)) {
        echo "Downloading {$filename}...\n";
        $image = file_get_contents($url);
        if ($image !== false) {
            file_put_contents($destination, $image);
            echo "Saved {$filename}\n";
        } else {
            echo "Failed to download {$filename}\n";
        }
    } else {
        echo "{$filename} already exists\n";
    }
}

echo "Done!\n";
