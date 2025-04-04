@extends('mark.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Media Details</h1>

        <div class="flex space-x-2">
            <a href="/mark/media" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Media Library
            </a>

            <form action="/mark/media/{{ $image['public_id'] }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this media?');">
                {!! csrf_fields() !!}
                <input type="hidden" name="redirect" value="/mark/media">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/2 relative group">
                <img src="{{ $image['url'] }}"
                     alt="{{ basename($image['public_id']) }}"
                     class="w-full h-auto">

                @php
                    $folder = dirname($image['public_id']);
                    $filename = basename($image['public_id']);
                    // If folder is '.', it means the image is in the root directory
                    if ($folder === '.') {
                        $folder = 'mark-cms';
                    }
                @endphp

                <a href="/mark/media/{{ $folder }}/{{ $filename }}"
                   class="absolute top-2 right-2 p-2 bg-white rounded-md shadow opacity-100 hover:bg-gray-100"
                   title="Full Screen Preview">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 011.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 011.414-1.414L15 13.586V12a1 1 0 011-1z" />
                    </svg>
                </a>
            </div>

            <div class="md:w-1/2 p-6">
                <h2 class="text-xl font-bold mb-4">{{ basename($image['public_id']) }}</h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Public ID</h3>
                        <p class="mt-1">{{ $image['public_id'] }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">URL</h3>
                        <div class="mt-1 flex items-center">
                            <input type="text"
                                   value="{{ $image['url'] }}"
                                   class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   readonly
                                   id="image-url">
                            <button type="button"
                                    class="ml-2 inline-flex items-center p-1.5 border border-transparent rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                                    onclick="copyToClipboard('image-url')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 2a1 1 0 000 2h2a1 1 0 100-2H8z" />
                                    <path d="M3 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v6h-4.586l1.293-1.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L10.414 13H15v3a2 2 0 01-2 2H5a2 2 0 01-2-2V5zM15 11h2a1 1 0 110 2h-2v-2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">HTML Tag</h3>
                        <div class="mt-1 flex items-center">
                            <input type="text"
                                   value='<img src="{{ $image['url'] }}" alt="{{ basename($image['public_id']) }}">'
                                   class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   readonly
                                   id="image-html">
                            <button type="button"
                                    class="ml-2 inline-flex items-center p-1.5 border border-transparent rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                                    onclick="copyToClipboard('image-html')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 2a1 1 0 000 2h2a1 1 0 100-2H8z" />
                                    <path d="M3 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v6h-4.586l1.293-1.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L10.414 13H15v3a2 2 0 01-2 2H5a2 2 0 01-2-2V5zM15 11h2a1 1 0 110 2h-2v-2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Markdown</h3>
                        <div class="mt-1 flex items-center">
                            <input type="text"
                                   value="![{{ basename($image['public_id']) }}]({{ $image['url'] }})"
                                   class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   readonly
                                   id="image-markdown">
                            <button type="button"
                                    class="ml-2 inline-flex items-center p-1.5 border border-transparent rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                                    onclick="copyToClipboard('image-markdown')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 2a1 1 0 000 2h2a1 1 0 100-2H8z" />
                                    <path d="M3 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v6h-4.586l1.293-1.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L10.414 13H15v3a2 2 0 01-2 2H5a2 2 0 01-2-2V5zM15 11h2a1 1 0 110 2h-2v-2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Format</h3>
                            <p class="mt-1">{{ strtoupper($image['format']) }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Size</h3>
                            <p class="mt-1">{{ formatFileSize($image['bytes']) }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Dimensions</h3>
                            <p class="mt-1">{{ $image['width'] }} × {{ $image['height'] }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Created</h3>
                            <p class="mt-1">{{ date('d.m.Y H:i', strtotime($image['created_at'])) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        document.execCommand('copy');

        // Show copied message
        const button = element.nextElementSibling;
        const originalHTML = button.innerHTML;
        button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>';
        button.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
        button.classList.add('bg-green-100', 'text-green-700');

        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('bg-green-100', 'text-green-700');
            button.classList.add('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
        }, 2000);
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>
@endsection

@php
function formatFileSize($bytes) {
    if ($bytes === 0) return '0 Bytes';

    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));

    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}

function basename($path) {
    return pathinfo($path, PATHINFO_BASENAME);
}
@endphp
