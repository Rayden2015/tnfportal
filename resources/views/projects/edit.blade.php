@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Project</h1>
    <form method="POST" action="{{ route('projects.update', $project) }}" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="title" value="{{ old('title', $project->title) }}" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="description">{{ old('description', $project->description) }}</textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="start_date" value="{{ old('start_date', $project->start_date) }}" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="end_date" value="{{ old('end_date', $project->end_date) }}" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                    @foreach(['draft','active','completed','cancelled'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $project->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Save</button>
    </form>
</div>
@endsection


