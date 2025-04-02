@extends('admin.layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-white">Articles</h1>
            <p class="mt-2 text-sm text-gray-300">A list of all articles in your CMS including their title, status, and language.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="/admin/articles/create" class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-400">
                Add article
            </a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="rounded-md bg-green-500 p-4 mt-4">
            <p class="text-sm text-white">{{ session('success') }}</p>
        </div>
    @endif

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-0">Title</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Language</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Created</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($articles as $article)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">
                                {{ $article->title }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ strtoupper($article->language) }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                <span class="inline-flex items-center rounded-md bg-{{ $article->status === 'published' ? 'green' : 'gray' }}-400/10 px-2 py-1 text-xs font-medium text-{{ $article->status === 'published' ? 'green' : 'gray' }}-400 ring-1 ring-inset ring-{{ $article->status === 'published' ? 'green' : 'gray' }}-400/20">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $article->created_at->format('d.m.Y H:i') }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a href="/admin/articles/{{ $article->id }}/edit" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection