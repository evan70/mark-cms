@extends('mark.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">AI Content Generator</h1>
            <p class="text-gray-400">Current generator: {{ $generatorName }}</p>
        </div>

        <div>
            <form action="{{ url('/mark/ai-content') }}" method="GET" class="flex items-center space-x-2">
                <select name="generator" class="py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm text-white">
                    @foreach($generators as $key => $name)
                        <option value="{{ $key }}" {{ $currentGenerator === $key ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Switch
                </button>
            </form>
        </div>
    </div>

    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">Generate Content</h2>

                <form id="ai-content-form" action="{{ url('/mark/ai-content/generate') }}" method="POST" class="space-y-4">
                    {!! csrf_fields() !!}
                    <!-- Manual CSRF token as fallback -->
                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                    <!-- Current generator -->
                    <input type="hidden" name="generator" value="{{ $currentGenerator }}">
                    <!-- Template Selection -->
                    <div>
                        <label for="template" class="block text-sm font-medium text-gray-300">Template</label>
                        <select id="template" name="template" class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm text-white">
                            @foreach($templates as $key => $template)
                                <option value="{{ $key }}">{{ $template['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Model Selection -->
                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-300">Model</label>
                        <select id="model" name="model" class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm text-white">
                            @foreach($models as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Temperature -->
                    <div>
                        <label for="temperature" class="block text-sm font-medium text-gray-300">Temperature (0.0 - 1.0)</label>
                        <input type="range" id="temperature" name="temperature" min="0" max="1" step="0.1" value="0.7" class="mt-1 block w-full">
                        <div class="flex justify-between text-xs text-gray-400">
                            <span>More Focused</span>
                            <span id="temperature-value">0.7</span>
                            <span>More Creative</span>
                        </div>
                    </div>

                    <!-- Parameters -->
                    <div id="parameters-container" class="space-y-4">
                        <!-- Parameters will be dynamically added here -->
                    </div>

                    <!-- Generate Button -->
                    <div>
                        <button type="submit" id="generate-button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Generate Content
                        </button>
                    </div>
                </form>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Generated Content</h2>

                <div class="relative">
                    <textarea id="generated-content" class="w-full h-96 p-4 bg-gray-700 text-white border border-gray-600 rounded-md font-mono text-sm" readonly>{{ $generatedContent ?? '' }}</textarea>

                    @if(isset($errorMessage))
                    <div class="mt-2 p-2 bg-red-800 text-white rounded">
                        {{ $errorMessage }}
                    </div>
                    @endif

                    <div class="absolute top-2 right-2 space-x-2">
                        <button id="copy-button" class="p-1 bg-gray-600 text-gray-300 rounded hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" title="Copy to clipboard">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                        </button>
                        <button id="use-button" class="p-1 bg-purple-600 text-white rounded hover:bg-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" title="Use in new article">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm text-gray-400">
                        <strong>Note:</strong> AI-generated content may contain inaccuracies or biases. Always review and edit the content before publishing.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const templateSelect = document.getElementById('template');
    const parametersContainer = document.getElementById('parameters-container');
    const temperatureInput = document.getElementById('temperature');
    const temperatureValue = document.getElementById('temperature-value');
    const generateButton = document.getElementById('generate-button');
    const loadingIndicator = document.getElementById('loading-indicator');
    const generatedContent = document.getElementById('generated-content');
    const copyButton = document.getElementById('copy-button');
    const useButton = document.getElementById('use-button');
    const aiContentForm = document.getElementById('ai-content-form');

    // Templates data
    const templates = @json($templates);

    // Update temperature value display
    temperatureInput.addEventListener('input', function() {
        temperatureValue.textContent = this.value;
    });

    // Update parameters when template changes
    templateSelect.addEventListener('change', function() {
        updateParameters();
    });

    // Initialize parameters
    updateParameters();

    // Copy generated content to clipboard
    copyButton.addEventListener('click', function() {
        generatedContent.select();
        document.execCommand('copy');

        // Show feedback
        const originalTitle = copyButton.title;
        copyButton.title = 'Copied!';
        setTimeout(() => {
            copyButton.title = originalTitle;
        }, 2000);
    });

    // Use generated content in new article
    useButton.addEventListener('click', function() {
        const content = generatedContent.value;
        if (!content) return;

        // Create a form to submit the content
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ url('/mark/content/create') }}';

        // Add content as a hidden field
        const contentField = document.createElement('input');
        contentField.type = 'hidden';
        contentField.name = 'ai_content';
        contentField.value = content;
        form.appendChild(contentField);

        // Submit the form
        document.body.appendChild(form);
        form.submit();
    });

    // Update parameters based on selected template
    function updateParameters() {
        const templateKey = templateSelect.value;
        const template = templates[templateKey];

        // Clear parameters container
        parametersContainer.innerHTML = '';

        // Add parameters
        if (template.parameters && template.parameters.length > 0) {
            template.parameters.forEach(param => {
                const paramDiv = document.createElement('div');

                const label = document.createElement('label');
                label.htmlFor = `param-${param}`;
                label.className = 'block text-sm font-medium text-gray-300';
                label.textContent = param.charAt(0).toUpperCase() + param.slice(1).replace('_', ' ');

                const input = document.createElement('input');
                input.type = 'text';
                input.id = `param-${param}`;
                input.name = `param_${param}`;
                input.className = 'mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-700 rounded-md bg-gray-700 text-white';
                input.required = true;

                paramDiv.appendChild(label);
                paramDiv.appendChild(input);

                parametersContainer.appendChild(paramDiv);
            });
        }
    }
});
</script>
@endsection
