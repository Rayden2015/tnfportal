@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">New Project</h1>
<form method="POST" action="{{ route('projects.store') }}" class="space-y-3">
    @csrf
    <input class="border p-2 w-full" name="title" placeholder="Title" />
    <textarea class="border p-2 w-full" name="description" placeholder="Description"></textarea>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <input type="date" class="border p-2 w-full" name="start_date" />
        <input type="date" class="border p-2 w-full" name="end_date" />
        <select name="status" class="border p-2 w-full">
            <option value="draft">Draft</option>
            <option value="active">Active</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection


