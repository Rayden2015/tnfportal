@extends('layouts.app')
@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Volunteers</h1>
    <a href="{{ route('volunteers.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">New Volunteer</a>
  </div>
<table class="w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Email</th>
            <th class="p-2 text-left">Phone</th>
            <th class="p-2 text-left">Notes</th>
            <th class="p-2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($volunteers as $volunteer)
            <tr class="border-t">
                <td class="p-2">{{ $volunteer->name }}</td>
                <td class="p-2">{{ $volunteer->email }}</td>
                <td class="p-2">{{ $volunteer->phone }}</td>
                <td class="p-2">{{ $volunteer->notes }}</td>
                <td class="p-2 text-right">
                    <a href="{{ route('volunteers.edit', $volunteer) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('volunteers.destroy', $volunteer) }}" method="POST" class="inline" onsubmit="return confirm('Delete volunteer?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $volunteers->links() }}</div>
@endsection


