@extends('admin.layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <form action="/admin/articles" method="POST" class="space-y-6">
        <div class="border-b border-gray-700 pb-6">
            <h2 class="text-xl font-semibold text-white">New Article</h2>
            <p class="mt-1 text-sm text-gray-400">Create a new article in your CMS.</p>
        </div>

        <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-white">Title</label>
                <div class="mt-2">
                    <input type="text" name="title" id="title" required
                           class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div>
                <label for="language" class="block text-sm font-medium text-white">Language</label>
                <select id="language" name="language" required
                        class="mt-2 block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                    @foreach(explode(',', env('AVAILABLE_LANGUAGES')) as $lang)
                        <option value="{{ $lang }}">{{ strtoupper($lang) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-white">Content</label>
                <div class="mt-2">
                    <textarea id="content" name="content" rows="15" required
                              class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-white">Status</label>
                <select id="status" name="status" required
                        class="mt-2 block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="/admin/articles" class="text-sm font-semibold text-white">Cancel</a>
            <button type="submit"
                    class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                Create article
            </button>
        </div>
    </form>
</div>
@endsection