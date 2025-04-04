@extends('mark.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Media Library</h1>

        <a href="/mark/media/create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Upload Media
        </a>
    </div>

    @if(isset($_SESSION['success_message']))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ $_SESSION['success_message'] }}</p>
        </div>
        @php unset($_SESSION['success_message']); @endphp
    @endif

    @if(empty($images))
        <div class="bg-gray-100 rounded-lg p-8 text-center">
            <p class="text-gray-500 mb-4">No media found.</p>
            <a href="/mark/media/create" class="text-purple-600 hover:text-purple-500">
                Upload your first media
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($images as $image)
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="relative group">
                        <a href="/mark/media/{{ $image['public_id'] }}" class="block">
                            <img src="{{ $image['url'] }}"
                                 alt="{{ basename($image['public_id']) }}"
                                 class="w-full h-32 object-cover">
                        </a>

                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-100 transition-opacity">
                            <a href="/mark/media/{{ $image['public_id'] }}" class="p-2 bg-white rounded-md mx-1 shadow hover:bg-gray-100" title="View Details">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </a>

                            @php
                                $folder = dirname($image['public_id']);
                                $filename = basename($image['public_id']);
                                // If folder is '.', it means the image is in the root directory
                                if ($folder === '.') {
                                    $folder = 'mark-cms';
                                }
                            @endphp

                            <a href="/mark/media/{{ $folder }}/{{ $filename }}" class="p-2 bg-white rounded-md mx-1 shadow hover:bg-gray-100" title="Full Screen Preview">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 011.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 011.414-1.414L15 13.586V12a1 1 0 011-1z" />
                                </svg>
                            </a>

                            <button type="button"
                                    class="p-2 bg-white rounded-md mx-1 shadow hover:bg-gray-100"
                                    title="Delete"
                                    onclick="event.preventDefault(); event.stopPropagation(); confirmDelete('{{ $image['public_id'] }}', '{{ basename($image['public_id']) }}');">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-3">
                        <h3 class="text-sm font-medium text-gray-900 truncate">
                            {{ basename($image['public_id']) }}
                        </h3>
                        <p class="text-xs text-gray-500">
                            {{ date('d.m.Y', strtotime($image['created_at'])) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        @if($next_cursor)
            <div class="mt-8 text-center">
                <a href="/mark/media?next_cursor={{ $next_cursor }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Load More
                </a>
            </div>
        @endif
    @endif
</div>

<!-- Media Picker Modal -->
<div id="media-picker-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-lg font-medium">Select Media</h2>
            <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeMediaPicker()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-4 overflow-y-auto max-h-[calc(90vh-8rem)]">
            <div id="media-picker-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($images as $image)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow cursor-pointer media-item"
                         data-public-id="{{ $image['public_id'] }}"
                         data-url="{{ $image['url'] }}"
                         onclick="selectMedia('{{ $image['public_id'] }}', '{{ $image['url'] }}')">
                        <img src="{{ $image['url'] }}"
                             alt="{{ basename($image['public_id']) }}"
                             class="w-full h-32 object-cover">

                        <div class="p-3">
                            <h3 class="text-sm font-medium text-gray-900 truncate">
                                {{ basename($image['public_id']) }}
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($next_cursor)
                <div class="mt-8 text-center">
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                            onclick="loadMoreMedia('{{ $next_cursor }}')">
                        Load More
                    </button>
                </div>
            @endif
        </div>

        <div class="flex justify-end p-4 border-t">
            <button type="button"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mr-2"
                    onclick="closeMediaPicker()">
                Cancel
            </button>

            <button type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                    onclick="confirmMediaSelection()">
                Select
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Media Picker
    let selectedMedia = null;
    let mediaPickerCallback = null;

    function openMediaPicker(callback) {
        mediaPickerCallback = callback;
        document.getElementById('media-picker-modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeMediaPicker() {
        document.getElementById('media-picker-modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        selectedMedia = null;

        // Remove selected class from all media items
        document.querySelectorAll('.media-item').forEach(item => {
            item.classList.remove('ring-2', 'ring-purple-500');
        });
    }

    function selectMedia(publicId, url) {
        selectedMedia = { publicId, url };

        // Remove selected class from all media items
        document.querySelectorAll('.media-item').forEach(item => {
            item.classList.remove('ring-2', 'ring-purple-500');
        });

        // Add selected class to selected media item
        document.querySelector(`.media-item[data-public-id="${publicId}"]`).classList.add('ring-2', 'ring-purple-500');
    }

    function confirmMediaSelection() {
        if (selectedMedia && typeof mediaPickerCallback === 'function') {
            mediaPickerCallback(selectedMedia);
        }

        closeMediaPicker();
    }

    function loadMoreMedia(nextCursor) {
        fetch(`/mark/api/media?next_cursor=${nextCursor}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const grid = document.getElementById('media-picker-grid');

                    data.data.resources.forEach(image => {
                        const div = document.createElement('div');
                        div.className = 'bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow cursor-pointer media-item';
                        div.dataset.publicId = image.public_id;
                        div.dataset.url = image.url;
                        div.onclick = () => selectMedia(image.public_id, image.url);

                        div.innerHTML = `
                            <img src="${image.url}"
                                 alt="${basename(image.public_id)}"
                                 class="w-full h-32 object-cover">

                            <div class="p-3">
                                <h3 class="text-sm font-medium text-gray-900 truncate">
                                    ${basename(image.public_id)}
                                </h3>
                            </div>
                        `;

                        grid.appendChild(div);
                    });

                    // Update load more button
                    const loadMoreButton = document.querySelector('[onclick^="loadMoreMedia"]');
                    if (loadMoreButton) {
                        if (data.data.next_cursor) {
                            loadMoreButton.setAttribute('onclick', `loadMoreMedia('${data.data.next_cursor}')`);
                        } else {
                            loadMoreButton.parentNode.remove();
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error loading more media:', error);
            });
    }

    function basename(path) {
        return path.split('/').pop();
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

    // Expose media picker to global scope
    window.openMediaPicker = openMediaPicker;
</script>
@endsection
