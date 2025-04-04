@extends('mark.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Media Preview</h1>

        <div class="flex space-x-2">
            <a href="/mark/media" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Media Library
            </a>

            <a href="{{ $image['url'] }}" download="{{ $image['filename'] }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Download
            </a>

            <button type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    onclick="confirmDelete('{{ $image['public_id'] }}', '{{ $image['filename'] }}')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Delete
            </button>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4 bg-gray-100 border-b">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium">{{ $image['filename'] }}</h2>

                <div class="flex space-x-2">
                    <button type="button"
                            class="inline-flex items-center p-2 border border-transparent rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                            onclick="toggleFullscreen()"
                            title="Toggle Fullscreen">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" id="fullscreen-icon">
                            <path d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 011.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 011.414-1.414L15 13.586V12a1 1 0 011-1z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor" id="exit-fullscreen-icon">
                            <path d="M5 8V6a1 1 0 011-1h1.586l-2.293-2.293a1 1 0 011.414-1.414L9 3.586V2a1 1 0 112 0v4a1 1 0 01-1 1H6a1 1 0 01-1-1zm10 0a1 1 0 01-1-1V6a1 1 0 00-1-1h-1.586l2.293-2.293a1 1 0 00-1.414-1.414L10 3.586V2a1 1 0 10-2 0v4a1 1 0 001 1h4a1 1 0 001-1zM5 12a1 1 0 011 1v1a1 1 0 001 1h1.586l-2.293 2.293a1 1 0 001.414 1.414L10 16.414V18a1 1 0 102 0v-4a1 1 0 00-1-1H7a1 1 0 00-1 1zm10 0a1 1 0 00-1 1v1a1 1 0 01-1 1h-1.586l2.293 2.293a1 1 0 01-1.414 1.414L10 16.414V18a1 1 0 11-2 0v-4a1 1 0 011-1h4a1 1 0 011 1z" />
                        </svg>
                    </button>

                    <button type="button"
                            class="inline-flex items-center p-2 border border-transparent rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                            onclick="zoomIn()"
                            title="Zoom In">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <button type="button"
                            class="inline-flex items-center p-2 border border-transparent rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                            onclick="zoomOut()"
                            title="Zoom Out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <button type="button"
                            class="inline-flex items-center p-2 border border-transparent rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                            onclick="resetZoom()"
                            title="Reset Zoom">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-auto p-4 bg-gray-800 flex justify-center items-center" id="image-container" style="height: calc(100vh - 200px);">
            <img src="{{ $image['url'] }}"
                 alt="{{ $image['filename'] }}"
                 class="max-w-full max-h-full object-contain transition-transform duration-200"
                 id="preview-image"
                 style="transform: scale(1);">
        </div>

        <div class="p-4 bg-gray-100 border-t">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-sm text-gray-500">URL:</span>
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Image zoom and fullscreen
    const imageContainer = document.getElementById('image-container');
    const previewImage = document.getElementById('preview-image');
    const fullscreenIcon = document.getElementById('fullscreen-icon');
    const exitFullscreenIcon = document.getElementById('exit-fullscreen-icon');

    let scale = 1;
    let isFullscreen = false;

    function zoomIn() {
        scale += 0.1;
        updateZoom();
    }

    function zoomOut() {
        scale = Math.max(0.1, scale - 0.1);
        updateZoom();
    }

    function resetZoom() {
        scale = 1;
        updateZoom();
    }

    function updateZoom() {
        previewImage.style.transform = `scale(${scale})`;
    }

    function toggleFullscreen() {
        if (!isFullscreen) {
            if (imageContainer.requestFullscreen) {
                imageContainer.requestFullscreen();
            } else if (imageContainer.webkitRequestFullscreen) {
                imageContainer.webkitRequestFullscreen();
            } else if (imageContainer.msRequestFullscreen) {
                imageContainer.msRequestFullscreen();
            }

            fullscreenIcon.classList.add('hidden');
            exitFullscreenIcon.classList.remove('hidden');
            isFullscreen = true;
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }

            fullscreenIcon.classList.remove('hidden');
            exitFullscreenIcon.classList.add('hidden');
            isFullscreen = false;
        }
    }

    // Handle fullscreen change
    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
    document.addEventListener('mozfullscreenchange', handleFullscreenChange);
    document.addEventListener('MSFullscreenChange', handleFullscreenChange);

    function handleFullscreenChange() {
        isFullscreen = !!document.fullscreenElement;

        if (isFullscreen) {
            fullscreenIcon.classList.add('hidden');
            exitFullscreenIcon.classList.remove('hidden');
        } else {
            fullscreenIcon.classList.remove('hidden');
            exitFullscreenIcon.classList.add('hidden');
        }
    }

    // Copy to clipboard
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

    // Delete confirmation
    function confirmDelete(publicId, filename) {
        if (confirm(`Are you sure you want to delete ${filename}?`)) {
            // Extract the base public ID (without folder)
            const basePublicId = publicId.split('/').pop();

            // Create form for delete request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/mark/media/${basePublicId}`;
            form.style.display = 'none';

            // Add CSRF token
            const csrfFields = document.createElement('div');
            csrfFields.innerHTML = `{!! csrf_fields() !!}`;
            form.appendChild(csrfFields.firstChild);
            form.appendChild(csrfFields.firstChild);

            // Add redirect parameter
            const redirectInput = document.createElement('input');
            redirectInput.type = 'hidden';
            redirectInput.name = 'redirect';
            redirectInput.value = '/mark/media';
            form.appendChild(redirectInput);

            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(event) {
        // Zoom in: +
        if (event.key === '+' || event.key === '=') {
            zoomIn();
        }

        // Zoom out: -
        if (event.key === '-' || event.key === '_') {
            zoomOut();
        }

        // Reset zoom: 0
        if (event.key === '0') {
            resetZoom();
        }

        // Fullscreen: F
        if (event.key === 'f' || event.key === 'F') {
            toggleFullscreen();
        }
    });
</script>
@endsection
