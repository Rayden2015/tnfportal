@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create Message Template</h1>
    <form action="{{ route('message_templates.store') }}" method="POST" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="title" id="title" required value="{{ old('title') }}" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
            @error('title')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Body</label>
            <textarea name="body" id="body" required rows="5" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">{{ old('body') }}</textarea>
            @error('body')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                Save Template
            </button>
        </div>
    </form>
</div>
@endsection
        </form>
    </div>
@endsection
