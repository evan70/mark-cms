<?php

/**
 * Database schema configuration
 *
 * This file contains the schema definition for the database.
 * It is used by the DatabaseInitializer service to create the initial database structure.
 */

return [
    'tables' => [
        // Regular Users
        'users' => function ($table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        },

        // Mark Users (CMS Users)
        'mark_users' => function ($table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->enum('role', ['admin', 'editor', 'contributor'])->default('contributor');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        },

        // Admin Users
        'admin_users' => function ($table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->enum('role', ['admin', 'editor'])->default('editor');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        },

        // Admin Permissions
        'admin_permissions' => function ($table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        },

        // Admin Role Permissions
        'admin_role_permissions' => function ($table) {
            $table->string('role');
            $table->foreignId('permission_id')->constrained('admin_permissions')->onDelete('cascade');
            $table->primary(['role', 'permission_id']);
        },

        // Admin Activity Log
        'admin_activity_log' => function ($table) {
            $table->id();
            $table->foreignId('admin_user_id')->constrained('admin_users')->onDelete('cascade');
            $table->string('action');
            $table->string('entity_type')->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('changes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        },

        // Languages
        'languages' => function ($table) {
            $table->id();
            $table->string('code', 5)->unique();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        },

        // Categories
        'categories' => function ($table) {
            $table->id();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        },

        // Category Translations
        'category_translations' => function ($table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['category_id', 'locale']);
        },

        // Tags
        'tags' => function ($table) {
            $table->id();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        },

        // Tag Translations
        'tag_translations' => function ($table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['tag_id', 'locale']);
        },

        // Articles
        'articles' => function ($table) {
            $table->id();
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        },

        // Article Translations
        'article_translations' => function ($table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('perex')->nullable();
            $table->text('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['article_id', 'locale']);
            $table->index('locale');
        },

        // Article Categories
        'article_categories' => function ($table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['article_id', 'category_id']);
        },

        // Article Tags
        'article_tags' => function ($table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['article_id', 'tag_id']);
        },
    ],

    // Table creation order (to handle foreign key constraints)
    'creation_order' => [
        'users',
        'mark_users',
        'admin_users',
        'admin_permissions',
        'admin_role_permissions',
        'admin_activity_log',
        'languages',
        'categories',
        'category_translations',
        'tags',
        'tag_translations',
        'articles',
        'article_translations',
        'article_categories',
        'article_tags',
    ],

    // Table drop order (reverse of creation order)
    'drop_order' => [
        'article_tags',
        'article_categories',
        'article_translations',
        'articles',
        'tag_translations',
        'tags',
        'category_translations',
        'categories',
        'languages',
        'admin_activity_log',
        'admin_role_permissions',
        'admin_permissions',
        'admin_users',
        'mark_users',
        'users',
    ],
];
