@extends('mark.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ isset($is_index) && $is_index ? 'Create Index' : 'Create Article' }}{{ $category ? ' in ' . ucfirst($category) : '' }}</h1>

            @if(!empty($breadcrumbs))
            <div class="flex items-center text-sm text-gray-400 mt-2">
                @foreach($breadcrumbs as $index => $breadcrumb)
                    @if($index > 0)
                        <span class="mx-2">/</span>
                    @endif

                    @if($breadcrumb['path'] === null || $loop->last)
                        <span>{{ $breadcrumb['name'] }}</span>
                    @else
                        <a href="{{ url('/mark/content') }}{{ $breadcrumb['path'] ? '?category=' . $breadcrumb['path'] : '' }}" class="text-blue-400 hover:text-blue-300">{{ $breadcrumb['name'] }}</a>
                    @endif
                @endforeach
            </div>
            @endif
        </div>

        <a href="{{ url('/mark/content') }}{{ $category ? '?category=' . urlencode($category) : '' }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to List
        </a>
    </div>

    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700 p-6">
        <form action="{{ url('/mark/content/create') }}" method="POST" enctype="multipart/form-data">
            {!! csrf_fields() !!}

            @if($category)
            <input type="hidden" name="category" value="{{ $category }}">
            @endif

            @if(isset($is_index) && $is_index)
            <input type="hidden" name="is_index" value="1">
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-700 rounded-md bg-gray-700 text-white" required>
                </div>

                <!-- Language -->
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-300">Language</label>
                    <select name="language" id="language" class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm text-white">
                        <option value="sk">Slovak</option>
                        <option value="en">English</option>
                        <option value="cs">Czech</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm text-white">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>

                <!-- Author -->
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-300">Author</label>
                    <input type="text" name="author" id="author" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-700 rounded-md bg-gray-700 text-white">
                </div>

                <!-- Featured Image -->
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-300">Featured Image</label>
                    <input type="file" name="featured_image" id="featured_image" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-700 rounded-md bg-gray-700 text-white">
                </div>

                <!-- Categories -->
                <div>
                    <label for="categories" class="block text-sm font-medium text-gray-300">Categories</label>
                    <select name="categories[]" id="categories" multiple class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-700 rounded-md bg-gray-700 text-white" size="5">
                        @if(isset($availableCategories) && is_array($availableCategories) && count($availableCategories) > 0)
                            @foreach($availableCategories as $availableCategory)
                                <option value="{{ $availableCategory['value'] }}">{{ $availableCategory['name'] }} ({{ $availableCategory['path'] }})</option>
                            @endforeach
                        @else
                            <option value="">No categories available</option>
                        @endif
                    </select>
                    <p class="mt-1 text-xs text-gray-400">Hold Ctrl (or Cmd) to select multiple categories</p>
                    <!-- Debug -->
                    <p class="mt-1 text-xs text-red-400">Debug: {{ isset($availableCategories) ? count($availableCategories) : 'No' }} categories available</p>
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-300">Tags (comma separated)</label>
                    <input type="text" name="tags" id="tags" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-700 rounded-md bg-gray-700 text-white">
                </div>

                <!-- Excerpt -->
                <div class="col-span-2">
                    <label for="excerpt" class="block text-sm font-medium text-gray-300">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-700 rounded-md bg-gray-700 text-white"></textarea>
                </div>

                <!-- Content -->
                <div class="col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-300">Content (Markdown)</label>
                    <textarea name="content" id="content" rows="20" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-700 rounded-md bg-gray-700 text-white font-mono">{{ $ai_content ?? '' }}</textarea>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Create Article
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Simple markdown preview (you can replace this with a more advanced editor like EasyMDE)
    document.addEventListener('DOMContentLoaded', function() {
        const contentField = document.getElementById('content');

        // Set default content
        if (!contentField.value) {
            contentField.value = `# Title

Write your article content here using Markdown.

## Subheading

- Bullet point 1
- Bullet point 2

[Link text](https://example.com)

![Image alt text](image-url.jpg)
`;
        }
    });
</script>
@endsection
