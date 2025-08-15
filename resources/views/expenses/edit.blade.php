@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Expense</h1>
    <form method="POST" action="{{ route('expenses.update', $expense) }}" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Project</label>
                <select name="project_id" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                    <option value="">-- Project --</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" @selected(old('project_id', $expense->project_id) == $project->id)>{{ $project->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                <input name="amount" value="{{ old('amount', $expense->amount) }}" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <input name="description" value="{{ old('description', $expense->description) }}" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" />
            </div>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Save</button>
    </form>
</div>
@endsection


