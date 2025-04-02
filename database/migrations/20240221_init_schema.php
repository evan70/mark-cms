<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class InitSchema 
{
    public function up(): void
    {
        $this->createLanguagesTable();
        $this->createCategoriesSchema();
        $this->createTagsSchema();
        $this->createArticlesSchema();
    }

    private function createLanguagesTable(): void 
    {
        if (!Capsule::schema()->hasTable('languages')) {
            Capsule::schema()->create('languages', function ($table) {
                $table->id();
                $table->string('code', 5)->unique();
                $table->string('name');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    private function createCategoriesSchema(): void 
    {
        Capsule::schema()->create('categories', function ($table) {
            $table->id();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Capsule::schema()->create('category_translations', function ($table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            
            $table->unique(['category_id', 'locale']);
        });
    }

    private function createTagsSchema(): void 
    {
        Capsule::schema()->create('tags', function ($table) {
            $table->id();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Capsule::schema()->create('tag_translations', function ($table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            
            $table->unique(['tag_id', 'locale']);
        });
    }

    private function createArticlesSchema(): void 
    {
        Capsule::schema()->create('articles', function ($table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Capsule::schema()->create('article_translations', function ($table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('title');
            $table->text('perex')->nullable();
            $table->text('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            
            $table->unique(['article_id', 'locale']);
            $table->index('locale');
        });

        Capsule::schema()->create('article_categories', function ($table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['article_id', 'category_id']);
        });

        Capsule::schema()->create('article_tags', function ($table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['article_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        $tables = [
            'article_tags',
            'article_categories',
            'article_translations',
            'articles',
            'tag_translations',
            'tags',
            'category_translations',
            'categories',
            'languages'
        ];

        foreach ($tables as $table) {
            Capsule::schema()->dropIfExists($table);
        }
    }
}