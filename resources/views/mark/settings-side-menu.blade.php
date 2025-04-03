@extends('mark.layouts.side-menu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Settings</h1>
    </div>

    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700 p-6">
        <h2 class="text-xl font-semibold mb-4">Layout Preferences</h2>
        
        <form method="POST" action="{{ url('/mark/settings/layout') }}">
            {!! csrf_fields() !!}
            
            <div class="mb-6">
                <label class="block text-gray-300 mb-2">Choose Layout</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="layout" value="mark.layouts.app" class="form-radio h-5 w-5 text-purple-600" {{ $layout_preference === 'mark.layouts.app' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-300">Top Navigation</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="layout" value="mark.layouts.side-menu" class="form-radio h-5 w-5 text-purple-600" {{ $layout_preference === 'mark.layouts.side-menu' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-300">Side Menu</span>
                    </label>
                </div>
            </div>
            
            <div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                    Save Preferences
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
