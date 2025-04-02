<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateInitialSchema
{
    public function up()
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

        // Languages
        Capsule::schema()->create('languages', function ($table) {
            $table->id();
            $table->string('code', 2)->unique();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Categories
        Capsule::schema()->create('categories', function ($table) {
            $table->id();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Capsule::schema()->create('category_translations', function ($table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('locale', 2);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            
            $table->unique(['category_id', 'locale']);
        });

        // Tags
        Capsule::schema()->create('tags', function ($table) {
            $table->id();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Capsule::schema()->create('tag_translations', function ($table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->string('locale', 2);
            $table->string('name');
            $table->timestamps();

            $table->unique(['tag_id', 'locale']);
        });

        // Articles
        Capsule::schema()->create('articles', function ($table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Capsule::schema()->create('article_translations', function ($table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->string('locale', 2);
            $table->string('title');
            $table->text('perex')->nullable();
            $table->text('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['article_id', 'locale']);
        });

        // Pivot tables
        Capsule::schema()->create('article_categories', function ($table) {
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->primary(['article_id', 'category_id']);
        });

        Capsule::schema()->create('article_tags', function ($table) {
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['article_id', 'tag_id']);
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('admin_role_permissions');
        Capsule::schema()->dropIfExists('admin_permissions');
        Capsule::schema()->dropIfExists('admin_activity_log');
        Capsule::schema()->dropIfExists('admin_users');
        Capsule::schema()->dropIfExists('article_tags');
        Capsule::schema()->dropIfExists('article_categories');
        Capsule::schema()->dropIfExists('article_translations');
        Capsule::schema()->dropIfExists('articles');
        Capsule::schema()->dropIfExists('tag_translations');
        Capsule::schema()->dropIfExists('tags');
        Capsule::schema()->dropIfExists('category_translations');
        Capsule::schema()->dropIfExists('categories');
        Capsule::schema()->dropIfExists('languages');
    }
}
