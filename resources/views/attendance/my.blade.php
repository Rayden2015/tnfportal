@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Attendance</h1>
    @if(isset($attendances) && $attendances->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->created_at->format('Y-m-d') }}</td>
                        <td>{{ $attendance->project->title ?? '-' }}</td>
                        <td>{{ ucfirst($attendance->status) }}</td>
                        <td>{{ $attendance->check_in }}</td>
                        <td>{{ $attendance->check_out }}</td>
                        <td>{{ $attendance->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $attendances->links() }}
    @else
        <p>No attendance records found.</p>
    @endif
</div>
@endsection
