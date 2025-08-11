@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">Edit Project</h1>
<form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-3">
    @csrf
    @method('PUT')
    <input class="border p-2 w-full" name="title" value="{{ old('title', $project->title) }}" />
    <textarea class="border p-2 w-full" name="description">{{ old('description', $project->description) }}</textarea>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <input type="date" class="border p-2 w-full" name="start_date" value="{{ old('start_date', $project->start_date) }}" />
        <input type="date" class="border p-2 w-full" name="end_date" value="{{ old('end_date', $project->end_date) }}" />
        <select name="status" class="border p-2 w-full">
            @foreach(['draft','active','completed','cancelled'] as $status)
                <option value="{{ $status }}" @selected(old('status', $project->status) === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection


