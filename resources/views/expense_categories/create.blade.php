@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Add Expense Category</h1>
    <form method="POST" action="{{ route('expense_categories.store') }}" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input name="name" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" required />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200"></textarea>
            </div>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Save</button>
    </form>
</div>
@endsection
