@extends('layouts.app')
@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Donations</h1>
    <a href="{{ route('donations.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">New Donation</a>
  </div>
<table class="w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2 text-left">Donor</th>
            <th class="p-2 text-left">Project</th>
            <th class="p-2 text-left">Amount</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($donations as $d)
            <tr class="border-t">
                <td class="p-2">{{ optional($d->donor)->name }}</td>
                <td class="p-2">{{ optional($d->project)->title }}</td>
                <td class="p-2">{{ $d->currency }} {{ number_format($d->amount,2) }}</td>
                <td class="p-2">{{ $d->status }}</td>
                <td class="p-2 text-right">
                    <a href="{{ route('donations.edit', $d) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('donations.destroy', $d) }}" method="POST" class="inline" onsubmit="return confirm('Delete donation?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $donations->links() }}</div>
@endsection


