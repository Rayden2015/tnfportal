@extends('layouts.app')
@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Donors</h1>
    <a href="{{ route('donors.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">New Donor</a>
  </div>
<table class="w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Email</th>
            <th class="p-2 text-left">Phone</th>
            <th class="p-2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($donors as $donor)
            <tr class="border-t">
                <td class="p-2">{{ $donor->name }}</td>
                <td class="p-2">{{ $donor->email }}</td>
                <td class="p-2">{{ $donor->phone }}</td>
                <td class="p-2 text-right">
                    <a href="{{ route('donors.edit', $donor) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('donors.destroy', $donor) }}" method="POST" class="inline" onsubmit="return confirm('Delete donor?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $donors->links() }}</div>
@endsection


