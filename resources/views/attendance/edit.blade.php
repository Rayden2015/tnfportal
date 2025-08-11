@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">Edit Attendance</h1>
<form method="POST" action="{{ route('attendance.update', $attendance) }}" class="space-y-3">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <select name="project_id" class="border p-2 w-full">
            @foreach($projects as $project)
                <option value="{{ $project->id }}" @selected(old('project_id', $attendance->project_id) == $project->id)>{{ $project->title }}</option>
            @endforeach
        </select>
        <select name="volunteer_id" class="border p-2 w-full">
            @foreach($volunteers as $volunteer)
                <option value="{{ $volunteer->id }}" @selected(old('volunteer_id', $attendance->volunteer_id) == $volunteer->id)>{{ $volunteer->name }}</option>
            @endforeach
        </select>
        <select name="status" class="border p-2 w-full">
            @foreach(['present','absent','excused'] as $status)
                <option value="{{ $status }}" @selected(old('status', $attendance->status) === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <input type="datetime-local" name="check_in" value="{{ old('check_in', optional($attendance->check_in)->format('Y-m-d\TH:i')) }}" class="border p-2 w-full" />
        <input type="datetime-local" name="check_out" value="{{ old('check_out', optional($attendance->check_out)->format('Y-m-d\TH:i')) }}" class="border p-2 w-full" />
    </div>
    <textarea name="notes" class="border p-2 w-full">{{ old('notes', $attendance->notes) }}</textarea>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection


