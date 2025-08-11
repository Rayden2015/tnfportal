@extends('layouts.app')
@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Attendance</h1>
    <a href="{{ route('attendance.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">New Entry</a>
  </div>
<table class="w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2 text-left">Project</th>
            <th class="p-2 text-left">Volunteer</th>
            <th class="p-2 text-left">Check In</th>
            <th class="p-2 text-left">Check Out</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $a)
            <tr class="border-t">
                <td class="p-2">{{ optional($a->project)->title }}</td>
                <td class="p-2">{{ optional($a->volunteer)->name }}</td>
                <td class="p-2">{{ $a->check_in }}</td>
                <td class="p-2">{{ $a->check_out }}</td>
                <td class="p-2">{{ $a->status }}</td>
                <td class="p-2 text-right">
                    <a href="{{ route('attendance.edit', $a) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('attendance.destroy', $a) }}" method="POST" class="inline" onsubmit="return confirm('Delete entry?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $attendances->links() }}</div>
@endsection


