<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class CategoriesSeeder
{
    public function run()
    {
        $categories = [
            [
                'slug' => 'technology',
                'is_active' => true,
                'translations' => [
                    'sk' => [
                        'name' => 'Technológie',
                        'description' => 'Články o technológiách a inováciách',
                        'meta_title' => 'Technológie a inovácie',
                        'meta_description' => 'Najnovšie články o technológiách, inováciách a digitálnom svete'
                    ],
                    'en' => [
                        'name' => 'Technology',
                        'description' => 'Articles about technology and innovation',
                        'meta_title' => 'Technology and Innovation',
                        'meta_description' => 'Latest articles about technology, innovation and digital world'
                    ],
                    'cs' => [
                        'name' => 'Technologie',
                        'description' => 'Články o technologiích a inovacích',
                        'meta_title' => 'Technologie a inovace',
                        'meta_description' => 'Nejnovější články o technologiích, inovacích a digitálním světě'
                    ]
                ]
            ],
            [
                'slug' => 'business',
                'is_active' => true,
                'translations' => [
                    'sk' => [
                        'name' => 'Biznis',
                        'description' => 'Články o podnikaní a ekonomike',
                        'meta_title' => 'Biznis a ekonomika',
                        'meta_description' => 'Články a novinky zo sveta biznisu a ekonomiky'
                    ],
                    'en' => [
                        'name' => 'Business',
                        'description' => 'Articles about business and economy',
                        'meta_title' => 'Business and Economy',
                        'meta_description' => 'Articles and news from business and economy world'
                    ],
                    'cs' => [
                        'name' => 'Byznys',
                        'description' => 'Články o podnikání a ekonomice',
                        'meta_title' => 'Byznys a ekonomika',
                        'meta_description' => 'Články a novinky ze světa byznysu a ekonomiky'
                    ]
                ]
            ],
            [
                'slug' => 'marketing',
                'is_active' => true,
                'translations' => [
                    'sk' => [
                        'name' => 'Marketing',
                        'description' => 'Digitálny marketing a stratégie',
                        'meta_title' => 'Marketing a stratégie',
                        'meta_description' => 'Moderné marketingové stratégie a trendy'
                    ],
                    'en' => [
                        'name' => 'Marketing',
                        'description' => 'Digital marketing and strategies',
                        'meta_title' => 'Marketing and Strategies',
                        'meta_description' => 'Modern marketing strategies and trends'
                    ],
                    'cs' => [
                        'name' => 'Marketing',
                        'description' => 'Digitální marketing a strategie',
                        'meta_title' => 'Marketing a strategie',
                        'meta_description' => 'Moderní marketingové strategie a trendy'
                    ]
                ]
            ],
            [
                'slug' => 'development',
                'is_active' => true,
                'translations' => [
                    'sk' => [
                        'name' => 'Vývoj',
                        'description' => 'Programovanie a vývoj softvéru',
                        'meta_title' => 'Vývoj softvéru',
                        'meta_description' => 'Články o programovaní a vývoji aplikácií'
                    ],
                    'en' => [
                        'name' => 'Development',
                        'description' => 'Programming and software development',
                        'meta_title' => 'Software Development',
                        'meta_description' => 'Articles about programming and app development'
                    ],
                    'cs' => [
                        'name' => 'Vývoj',
                        'description' => 'Programování a vývoj softwaru',
                        'meta_title' => 'Vývoj softwaru',
                        'meta_description' => 'Články o programování a vývoji aplikací'
                    ]
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            // Insert category
            $categoryId = Capsule::table('categories')->insertGetId([
                'slug' => $categoryData['slug'],
                'is_active' => $categoryData['is_active'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Insert translations
            foreach ($categoryData['translations'] as $locale => $translation) {
                Capsule::table('category_translations')->insert([
                    'category_id' => $categoryId,
                    'locale' => $locale,
                    'name' => $translation['name'],
                    'description' => $translation['description'],
                    'meta_title' => $translation['meta_title'],
                    'meta_description' => $translation['meta_description'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
