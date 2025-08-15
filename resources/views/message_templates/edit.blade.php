@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Message Template</h1>
    <form action="{{ route('message_templates.update', $messageTemplate->id) }}" method="POST" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Template Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $messageTemplate->name) }}" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
            @error('name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Template Body</label>
            <textarea id="body" name="body" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">{{ old('body', $messageTemplate->body) }}</textarea>
            @error('body')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Update Template</button>
            <a href="{{ route('message_templates.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold">Back to Templates</a>
        </div>
    </form>
</div>
@endsection
