@extends('mark.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Upload Media</h1>

        <a href="/mark/media" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Media Library
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <form action="/mark/media" method="POST" enctype="multipart/form-data" id="upload-form">
                {!! csrf_fields() !!}
                <!-- Manual CSRF token as fallback -->
                <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">
                        File
                    </label>

                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md" id="dropzone">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                    <span>Upload a file</span>
                                    <input id="file" name="file" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF up to 10MB
                            </p>
                        </div>
                    </div>

                    <div id="preview" class="mt-4 hidden">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md overflow-hidden">
                                <img id="preview-image" src="#" alt="Preview" class="h-full w-full object-cover">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900" id="preview-name"></h4>
                                        <p class="text-sm text-gray-500" id="preview-size"></p>
                                    </div>
                                    <button type="button" class="text-red-500 hover:text-red-700" id="remove-file">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-1">
                                    <div class="bg-gray-200 rounded-full overflow-hidden">
                                        <div id="progress-bar" class="bg-purple-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="folder" class="block text-sm font-medium text-gray-700 mb-1">
                        Folder (optional)
                    </label>
                    <input type="text"
                           id="folder"
                           name="folder"
                           value="mark-cms"
                           class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-1 text-sm text-gray-500">
                        Folder path in Cloudinary (e.g., mark-cms/blog)
                    </p>
                </div>

                <div class="mb-6">
                    <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">
                        Tags (optional)
                    </label>
                    <input type="text"
                           id="tags"
                           name="tags"
                           placeholder="blog, featured, hero"
                           class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-1 text-sm text-gray-500">
                        Comma-separated tags
                    </p>
                </div>

                <div class="flex justify-end">
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mr-2"
                            onclick="window.location.href='/mark/media'">
                        Cancel
                    </button>

                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                            id="upload-button">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // File upload preview
    const fileInput = document.getElementById('file');
    const dropzone = document.getElementById('dropzone');
    const preview = document.getElementById('preview');
    const previewImage = document.getElementById('preview-image');
    const previewName = document.getElementById('preview-name');
    const previewSize = document.getElementById('preview-size');
    const removeFile = document.getElementById('remove-file');
    const progressBar = document.getElementById('progress-bar');
    const uploadForm = document.getElementById('upload-form');
    const uploadButton = document.getElementById('upload-button');

    // Handle file input change
    fileInput.addEventListener('change', handleFileSelect);

    // Handle drag and drop
    dropzone.addEventListener('dragover', handleDragOver);
    dropzone.addEventListener('dragleave', handleDragLeave);
    dropzone.addEventListener('drop', handleDrop);

    // Handle remove file
    removeFile.addEventListener('click', handleRemoveFile);

    // Handle form submit
    uploadForm.addEventListener('submit', handleSubmit);

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            showPreview(file);
        }
    }

    function handleDragOver(event) {
        event.preventDefault();
        event.stopPropagation();
        dropzone.classList.add('border-purple-500');
    }

    function handleDragLeave(event) {
        event.preventDefault();
        event.stopPropagation();
        dropzone.classList.remove('border-purple-500');
    }

    function handleDrop(event) {
        event.preventDefault();
        event.stopPropagation();
        dropzone.classList.remove('border-purple-500');

        const file = event.dataTransfer.files[0];
        if (file) {
            fileInput.files = event.dataTransfer.files;
            showPreview(file);
        }
    }

    function showPreview(file) {
        // Check if file is an image
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewName.textContent = file.name;
            previewSize.textContent = formatFileSize(file.size);
            preview.classList.remove('hidden');
            dropzone.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    function handleRemoveFile() {
        fileInput.value = '';
        preview.classList.add('hidden');
        dropzone.classList.remove('hidden');
        progressBar.style.width = '0%';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function handleSubmit(event) {
        event.preventDefault();

        if (!fileInput.files[0]) {
            alert('Please select a file to upload.');
            return;
        }

        // Disable upload button
        uploadButton.disabled = true;
        uploadButton.innerHTML = 'Uploading...';

        // Create FormData
        const formData = new FormData(uploadForm);

        // Add CSRF token
        // Get all hidden inputs from the form
        const hiddenInputs = uploadForm.querySelectorAll('input[type="hidden"]');
        hiddenInputs.forEach(input => {
            formData.append(input.name, input.value);
        });

        // Upload file using XMLHttpRequest to show progress
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/mark/api/media', true);

        // Handle progress
        xhr.upload.addEventListener('progress', function(event) {
            if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                progressBar.style.width = percentComplete + '%';
            }
        });

        // Handle response
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = '/mark/media';
                } else {
                    alert('Upload failed: ' + response.message);
                    uploadButton.disabled = false;
                    uploadButton.innerHTML = 'Upload';
                }
            } else {
                alert('Upload failed. Please try again.');
                uploadButton.disabled = false;
                uploadButton.innerHTML = 'Upload';
            }
        };

        // Handle error
        xhr.onerror = function() {
            alert('Upload failed. Please try again.');
            uploadButton.disabled = false;
            uploadButton.innerHTML = 'Upload';
        };

        // Send request
        xhr.send(formData);
    }
</script>
@endsection
