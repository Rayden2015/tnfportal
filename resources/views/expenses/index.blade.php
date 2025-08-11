@extends('layouts.app')
@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Expenses</h1>
    <a href="{{ route('expenses.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">New Expense</a>
  </div>
<table class="w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2 text-left">Project</th>
            <th class="p-2 text-left">Amount</th>
            <th class="p-2 text-left">Description</th>
            <th class="p-2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($expenses as $e)
            <tr class="border-t">
                <td class="p-2">{{ optional($e->project)->title }}</td>
                <td class="p-2">{{ number_format($e->amount,2) }}</td>
                <td class="p-2">{{ $e->description }}</td>
                <td class="p-2 text-right">
                    <a href="{{ route('expenses.edit', $e) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('expenses.destroy', $e) }}" method="POST" class="inline" onsubmit="return confirm('Delete expense?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $expenses->links() }}</div>
@endsection


