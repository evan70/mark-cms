<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class ArticlesSeeder
{
    public function run()
    {
        $articles = [
            [
                'slug' => 'welcome-to-our-blog',
                'featured_image' => '/uploads/welcome.jpg',
                'is_published' => true,
                'published_at' => '2024-02-20 12:00:00',
                'translations' => [
                    'sk' => [
                        'title' => 'Vitajte na našom blogu',
                        'perex' => 'Prvý článok na našom novom blogu',
                        'content' => "# Vitajte\n\nToto je prvý článok na našom blogu. Budeme sa venovať technológiám, inováciám a biznisu.",
                        'meta_title' => 'Vitajte na blogu',
                        'meta_description' => 'Prvý článok na našom technologickom blogu'
                    ],
                    'en' => [
                        'title' => 'Welcome to our blog',
                        'perex' => 'First article on our new blog',
                        'content' => "# Welcome\n\nThis is the first article on our blog. We will focus on technology, innovation and business.",
                        'meta_title' => 'Welcome to the blog',
                        'meta_description' => 'First article on our technology blog'
                    ],
                    'cs' => [
                        'title' => 'Vítejte na našem blogu',
                        'perex' => 'První článek na našem novém blogu',
                        'content' => "# Vítejte\n\nToto je první článek na našem blogu. Budeme se věnovat technologiím, inovacím a byznysu.",
                        'meta_title' => 'Vítejte na blogu',
                        'meta_description' => 'První článek na našem technologickém blogu'
                    ]
                ],
                'categories' => ['technology', 'business'],
                'tags' => ['php', 'javascript']
            ],
            [
                'slug' => 'artificial-intelligence-in-2024',
                'featured_image' => '/uploads/ai-2024.jpg',
                'is_published' => true,
                'published_at' => '2024-02-21 14:30:00',
                'translations' => [
                    'sk' => [
                        'title' => 'Umelá inteligencia v roku 2024',
                        'perex' => 'Ako AI mení svet technológií a biznisu',
                        'content' => "# Umelá inteligencia v roku 2024\n\nV tomto článku sa pozrieme na najnovšie trendy v oblasti umelej inteligencie a jej vplyv na rôzne odvetvia.\n\n## Hlavné trendy\n\n1. Generatívna AI\n2. Strojové učenie\n3. Prirodzené spracovanie jazyka",
                        'meta_title' => 'AI trendy 2024',
                        'meta_description' => 'Prehľad trendov v oblasti umelej inteligencie pre rok 2024'
                    ],
                    'en' => [
                        'title' => 'Artificial Intelligence in 2024',
                        'perex' => 'How AI is changing the world of technology and business',
                        'content' => "# Artificial Intelligence in 2024\n\nIn this article, we'll look at the latest trends in artificial intelligence and its impact on various industries.\n\n## Main Trends\n\n1. Generative AI\n2. Machine Learning\n3. Natural Language Processing",
                        'meta_title' => 'AI Trends 2024',
                        'meta_description' => 'Overview of artificial intelligence trends for 2024'
                    ],
                    'cs' => [
                        'title' => 'Umělá inteligence v roce 2024',
                        'perex' => 'Jak AI mění svět technologií a byznysu',
                        'content' => "# Umělá inteligence v roce 2024\n\nV tomto článku se podíváme na nejnovější trendy v oblasti umělé inteligence a její vliv na různá odvětví.\n\n## Hlavní trendy\n\n1. Generativní AI\n2. Strojové učení\n3. Přirozené zpracování jazyka",
                        'meta_title' => 'AI trendy 2024',
                        'meta_description' => 'Přehled trendů v oblasti umělé inteligence pro rok 2024'
                    ]
                ],
                'categories' => ['technology'],
                'tags' => ['artificial-intelligence']
            ],
            [
                'slug' => 'modern-javascript-development',
                'featured_image' => '/uploads/javascript.jpg',
                'is_published' => true,
                'published_at' => '2024-02-22 09:15:00',
                'translations' => [
                    'sk' => [
                        'title' => 'Moderný vývoj v JavaScripte',
                        'perex' => 'Najnovšie trendy a best practices v JavaScript vývoji',
                        'content' => "# Moderný JavaScript\n\nSpoznajte najnovšie funkcie a postupy v modernom JavaScripte.\n\n## Témy\n\n- ES6+ funkcie\n- TypeScript\n- React a Vue.js\n- Testing\n- Performance optimalizácia",
                        'meta_title' => 'Moderný JavaScript vývoj',
                        'meta_description' => 'Komplexný guide moderným JavaScript vývojom'
                    ],
                    'en' => [
                        'title' => 'Modern JavaScript Development',
                        'perex' => 'Latest trends and best practices in JavaScript development',
                        'content' => "# Modern JavaScript\n\nDiscover the latest features and practices in modern JavaScript.\n\n## Topics\n\n- ES6+ features\n- TypeScript\n- React and Vue.js\n- Testing\n- Performance optimization",
                        'meta_title' => 'Modern JavaScript Development',
                        'meta_description' => 'Comprehensive guide to modern JavaScript development'
                    ],
                    'cs' => [
                        'title' => 'Moderní vývoj v JavaScriptu',
                        'perex' => 'Nejnovější trendy a best practices v JavaScript vývoji',
                        'content' => "# Moderní JavaScript\n\nSeznamte se s nejnovějšími funkcemi a postupy v moderním JavaScriptu.\n\n## Témata\n\n- ES6+ funkce\n- TypeScript\n- React a Vue.js\n- Testování\n- Performance optimalizace",
                        'meta_title' => 'Moderní JavaScript vývoj',
                        'meta_description' => 'Komplexní průvodce moderním JavaScript vývojem'
                    ]
                ],
                'categories' => ['technology'],
                'tags' => ['javascript']
            ],
            [
                'slug' => 'php-8-2-features',
                'featured_image' => '/uploads/php82.jpg',
                'is_published' => true,
                'published_at' => '2024-02-23 16:45:00',
                'translations' => [
                    'sk' => [
                        'title' => 'Novinky v PHP 8.2',
                        'perex' => 'Prehľad nových funkcií a vylepšení v PHP 8.2',
                        'content' => "# PHP 8.2 Novinky\n\nPHP 8.2 prináša množstvo zaujímavých vylepšení a nových funkcií.\n\n## Kľúčové vylepšenia\n\n1. Readonly classes\n2. Disjunctive normal form types\n3. Stand-alone null a false types\n4. New random extension",
                        'meta_title' => 'PHP 8.2 Nové funkcie',
                        'meta_description' => 'Kompletný prehľad noviniek v PHP 8.2'
                    ],
                    'en' => [
                        'title' => 'New Features in PHP 8.2',
                        'perex' => 'Overview of new features and improvements in PHP 8.2',
                        'content' => "# PHP 8.2 Features\n\nPHP 8.2 brings many interesting improvements and new features.\n\n## Key Improvements\n\n1. Readonly classes\n2. Disjunctive normal form types\n3. Standalone null and false types\n4. New random extension",
                        'meta_title' => 'PHP 8.2 New Features',
                        'meta_description' => 'Complete overview of new features in PHP 8.2'
                    ],
                    'cs' => [
                        'title' => 'Novinky v PHP 8.2',
                        'perex' => 'Přehled nových funkcí a vylepšení v PHP 8.2',
                        'content' => "# PHP 8.2 Novinky\n\nPHP 8.2 přináší množství zajímavých vylepšení a nových funkcí.\n\n## Klíčová vylepšení\n\n1. Readonly třídy\n2. Disjunktivní normální forma typů\n3. Samostatné null a false typy\n4. Nová random extension",
                        'meta_title' => 'PHP 8.2 Nové funkce',
                        'meta_description' => 'Kompletní přehled novinek v PHP 8.2'
                    ]
                ],
                'categories' => ['technology'],
                'tags' => ['php']
            ],
            [
                'slug' => 'digital-marketing-trends-2024',
                'featured_image' => '/uploads/digital-marketing.jpg',
                'is_published' => true,
                'published_at' => '2024-02-24 10:00:00',
                'translations' => [
                    'sk' => [
                        'title' => 'Trendy v digitálnom marketingu 2024',
                        'perex' => 'Aké marketingové stratégie budú dominovať v roku 2024?',
                        'content' => "# Digitálny marketing v roku 2024\n\nSpoznajte najnovšie trendy v digitálnom marketingu, ktoré budú formovať rok 2024.\n\n## Kľúčové trendy\n\n1. Video marketing\n2. Influencer marketing\n3. AI v marketingu\n4. Voice search optimalizácia",
                        'meta_title' => 'Trendy v digitálnom marketingu 2024',
                        'meta_description' => 'Prehľad najdôležitejších trendov v digitálnom marketingu pre rok 2024'
                    ],
                    'en' => [
                        'title' => 'Digital Marketing Trends 2024',
                        'perex' => 'What marketing strategies will dominate in 2024?',
                        'content' => "# Digital Marketing in 2024\n\nDiscover the latest trends in digital marketing that will shape 2024.\n\n## Key Trends\n\n1. Video Marketing\n2. Influencer Marketing\n3. AI in Marketing\n4. Voice Search Optimization",
                        'meta_title' => 'Digital Marketing Trends 2024',
                        'meta_description' => 'Overview of the most important digital marketing trends for 2024'
                    ],
                    'cs' => [
                        'title' => 'Trendy v digitálním marketingu 2024',
                        'perex' => 'Jaké marketingové strategie budou dominovat v roce 2024?',
                        'content' => "# Digitální marketing v roce 2024\n\nSeznamte se s nejnovějšími trendy v digitálním marketingu, které budou formovat rok 2024.\n\n## Klíčové trendy\n\n1. Video marketing\n2. Influencer marketing\n3. AI v marketingu\n4. Voice search optimalizace",
                        'meta_title' => 'Trendy v digitálním marketingu 2024',
                        'meta_description' => 'Přehled nejdůležitějších trendů v digitálním marketingu pro rok 2024'
                    ]
                ],
                'categories' => ['marketing', 'business'],
                'tags' => ['marketing']
            ],
            [
                'slug' => 'web-development-best-practices',
                'featured_image' => '/uploads/web-dev.jpg',
                'is_published' => true,
                'published_at' => '2024-02-25 11:30:00',
                'translations' => [
                    'sk' => [
                        'title' => 'Best practices vo vývoji webových aplikácií',
                        'perex' => 'Osvedčené postupy pre moderný vývoj webu',
                        'content' => "# Vývoj moderných webových aplikácií\n\nSpoznajte najlepšie praktiky pre vývoj výkonných a škálovateľných webových aplikácií.\n\n## Hlavné témy\n\n1. Performance optimalizácia\n2. Security best practices\n3. Clean code principles\n4. Testing strategies",
                        'meta_title' => 'Best practices vo vývoji webu',
                        'meta_description' => 'Komplexný guide osvedčenými postupmi vo vývoji webových aplikácií'
                    ],
                    'en' => [
                        'title' => 'Web Development Best Practices',
                        'perex' => 'Proven practices for modern web development',
                        'content' => "# Modern Web Application Development\n\nLearn the best practices for developing performant and scalable web applications.\n\n## Main Topics\n\n1. Performance optimization\n2. Security best practices\n3. Clean code principles\n4. Testing strategies",
                        'meta_title' => 'Web Development Best Practices',
                        'meta_description' => 'Comprehensive guide to proven practices in web application development'
                    ],
                    'cs' => [
                        'title' => 'Best practices ve vývoji webových aplikací',
                        'perex' => 'Osvědčené postupy pro moderní vývoj webu',
                        'content' => "# Vývoj moderních webových aplikací\n\nSeznamte se s nejlepšími praktikami pro vývoj výkonných a škálovatelných webových aplikací.\n\n## Hlavní témata\n\n1. Performance optimalizace\n2. Security best practices\n3. Clean code principles\n4. Testing strategies",
                        'meta_title' => 'Best practices ve vývoji webu',
                        'meta_description' => 'Komplexní průvodce osvědčenými postupy ve vývoji webových aplikací'
                    ]
                ],
                'categories' => ['development', 'technology'],
                'tags' => ['php', 'javascript']
            ]
        ];

        foreach ($articles as $article) {
            // Insert article
            $articleId = Capsule::table('articles')->insertGetId([
                'slug' => $article['slug'],
                'featured_image' => $article['featured_image'],
                'is_published' => $article['is_published'],
                'published_at' => $article['published_at'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Insert translations
            foreach ($article['translations'] as $locale => $translation) {
                Capsule::table('article_translations')->insert([
                    'article_id' => $articleId,
                    'locale' => $locale,
                    'title' => $translation['title'],
                    'perex' => $translation['perex'],
                    'content' => $translation['content'],
                    'meta_title' => $translation['meta_title'],
                    'meta_description' => $translation['meta_description'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            // Attach categories
            foreach ($article['categories'] as $categorySlug) {
                $categoryId = Capsule::table('categories')->where('slug', $categorySlug)->value('id');
                if ($categoryId) {
                    Capsule::table('article_categories')->insert([
                        'article_id' => $articleId,
                        'category_id' => $categoryId
                    ]);
                }
            }

            // Attach tags
            foreach ($article['tags'] as $tagSlug) {
                $tagId = Capsule::table('tags')->where('slug', $tagSlug)->value('id');
                if ($tagId) {
                    Capsule::table('article_tags')->insert([
                        'article_id' => $articleId,
                        'tag_id' => $tagId
                    ]);
                }
            }
        }
    }
}
