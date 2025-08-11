@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">New Expense</h1>
<form method="POST" action="{{ route('expenses.store') }}" class="space-y-3">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <select name="project_id" class="border p-2 w-full">
            <option value="">-- Project --</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->title }}</option>
            @endforeach
        </select>
        <input name="amount" placeholder="Amount" class="border p-2 w-full" />
        <input name="description" placeholder="Description" class="border p-2 w-full" />
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
  </form>
@endsection


