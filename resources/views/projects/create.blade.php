@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">New Project</h1>
    <form method="POST" action="{{ route('projects.store') }}" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="title" placeholder="Title" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="description" placeholder="Description"></textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="start_date" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="end_date" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                    <option value="draft">Draft</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Save</button>
    </form>
</div>
@endsection


