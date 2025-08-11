@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">Edit Expense</h1>
<form method="POST" action="{{ route('expenses.update', $expense) }}" class="space-y-3">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <select name="project_id" class="border p-2 w-full">
            <option value="">-- Project --</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" @selected(old('project_id', $expense->project_id) == $project->id)>{{ $project->title }}</option>
            @endforeach
        </select>
        <input name="amount" value="{{ old('amount', $expense->amount) }}" class="border p-2 w-full" />
        <input name="description" value="{{ old('description', $expense->description) }}" class="border p-2 w-full" />
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
  </form>
@endsection


