@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">New Attendance</h1>
    <form method="POST" action="{{ route('attendance.store') }}" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Project</label>
                <select name="project_id" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Volunteer</label>
                <select name="volunteer_id" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                    @foreach($volunteers as $volunteer)
                        <option value="{{ $volunteer->id }}">{{ $volunteer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                    @foreach(['present','absent','excused'] as $status)
                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Check In</label>
                <input type="datetime-local" name="check_in" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Check Out</label>
                <input type="datetime-local" name="check_out" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" />
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea name="notes" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" placeholder="Notes"></textarea>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Save</button>
    </form>
</div>
@endsection


