<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class TagsSeeder
{
    public function run()
    {
        $tags = [
            [
                'slug' => 'php',
                'translations' => [
                    'sk' => ['name' => 'PHP'],
                    'en' => ['name' => 'PHP'],
                    'cs' => ['name' => 'PHP']
                ]
            ],
            [
                'slug' => 'javascript',
                'translations' => [
                    'sk' => ['name' => 'JavaScript'],
                    'en' => ['name' => 'JavaScript'],
                    'cs' => ['name' => 'JavaScript']
                ]
            ],
            [
                'slug' => 'artificial-intelligence',
                'translations' => [
                    'sk' => ['name' => 'Umelá inteligencia'],
                    'en' => ['name' => 'Artificial Intelligence'],
                    'cs' => ['name' => 'Umělá inteligence']
                ]
            ],
            [
                'slug' => 'marketing',
                'translations' => [
                    'sk' => ['name' => 'Marketing'],
                    'en' => ['name' => 'Marketing'],
                    'cs' => ['name' => 'Marketing']
                ]
            ]
        ];

        foreach ($tags as $tag) {
            // Insert tag
            $tagId = Capsule::table('tags')->insertGetId([
                'slug' => $tag['slug'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Insert translations
            foreach ($tag['translations'] as $locale => $translation) {
                Capsule::table('tag_translations')->insert([
                    'tag_id' => $tagId,
                    'locale' => $locale,
                    'name' => $translation['name'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
