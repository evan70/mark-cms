@props([
    'type' => 'info',
    'dismissible' => false
])

@php
    $classes = [
        'info' => 'bg-blue-100 text-blue-800 border-blue-200',
        'success' => 'bg-green-100 text-green-800 border-green-200',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'error' => 'bg-red-100 text-red-800 border-red-200'
    ][$type] ?? 'bg-blue-100 text-blue-800 border-blue-200';
@endphp

<div class="rounded-lg p-4 border {{ $classes }} mb-4" role="alert">
    @if($dismissible)
        <div class="flex justify-between items-start">
            <div>{{ $slot }}</div>
            <button type="button" class="text-gray-250 hover:text-gray-150" onclick="this.parentElement.parentElement.remove()">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    @else
        {{ $slot }}
    @endif
</div>