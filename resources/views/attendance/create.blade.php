@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">New Attendance</h1>
<form method="POST" action="{{ route('attendance.store') }}" class="space-y-3">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <select name="project_id" class="border p-2 w-full">
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->title }}</option>
            @endforeach
        </select>
        <select name="volunteer_id" class="border p-2 w-full">
            @foreach($volunteers as $volunteer)
                <option value="{{ $volunteer->id }}">{{ $volunteer->name }}</option>
            @endforeach
        </select>
        <select name="status" class="border p-2 w-full">
            @foreach(['present','absent','excused'] as $status)
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <input type="datetime-local" name="check_in" class="border p-2 w-full" />
        <input type="datetime-local" name="check_out" class="border p-2 w-full" />
    </div>
    <textarea name="notes" class="border p-2 w-full" placeholder="Notes"></textarea>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection


