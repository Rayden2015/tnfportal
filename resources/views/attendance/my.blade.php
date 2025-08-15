@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">My Attendance</h1>
        <p class="text-gray-500">View your attendance records for all projects.</p>
    </div>
    @if(isset($attendances) && $attendances->count())
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($attendances as $attendance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $attendance->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $attendance->project->title ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-block px-2 py-1 rounded text-xs font-medium {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : ($attendance->status === 'absent' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $attendance->check_in }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $attendance->check_out }}</td>
                            <td class="px-6 py-4 whitespace-pre-line text-sm text-gray-700">{{ $attendance->notes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $attendances->links() }}</div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-700">No attendance records found.</p>
        </div>
    @endif
</div>
@endsection
