<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class InitDatabase
{
    public function up(): void
    {
        // Admin Users
        $this->createAdminSchema();
        
        // Content Management
        $this->createLanguagesTable();
        $this->createCategoriesSchema();
        $this->createTagsSchema();
        $this->createArticlesSchema();
    }

    private function createAdminSchema(): void
    {
        // Admin Users
        Capsule::schema()->create('admin_users', function ($table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->enum('role', ['admin', 'editor'])->default('editor');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        // Admin Permissions
        Capsule::schema()->create('admin_permissions', function ($table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Admin Role Permissions
        Capsule::schema()->create('admin_role_permissions', function ($table) {
            $table->string('role');
            $table->foreignId('permission_id')->constrained('admin_permissions')->onDelete('cascade');
            $table->primary(['role', 'permission_id']);
        });

        // Admin Activity Log
        Capsule::schema()->create('admin_activity_log', function ($table) {
            $table->id();
            $table->foreignId('admin_user_id')->constrained('admin_users')->onDelete('cascade');
            $table->string('action');
            $table->string('entity_type')->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('changes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    private function createLanguagesTable(): void 
    {
        Capsule::schema()->create('languages', function ($table) {
            $table->id();
            $table->string('code', 5)->unique();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
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
            // Content tables
            'article_tags',
            'article_categories',
            'article_translations',
            'articles',
            'tag_translations',
            'tags',
            'category_translations',
            'categories',
            'languages',
            
            // Admin tables
            'admin_role_permissions',
            'admin_permissions',
            'admin_activity_log',
            'admin_users'
        ];

        foreach ($tables as $table) {
            Capsule::schema()->dropIfExists($table);
        }
    }
}
