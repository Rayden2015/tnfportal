@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Expense Categories</h1>
    <a href="{{ route('expense_categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-4 inline-block">Add Category</a>
    <table class="min-w-full bg-white rounded-xl shadow">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Description</th>
                <th class="p-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr class="border-t">
                <td class="p-2">{{ $category->name }}</td>
                <td class="p-2">{{ $category->description }}</td>
                <td class="p-2 text-right">
                    <a href="{{ route('expense_categories.edit', $category) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form method="POST" action="{{ route('expense_categories.destroy', $category) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
