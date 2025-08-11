<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Project;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['project','volunteer'])->latest()->paginate(15);
        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $projects = Project::orderBy('title')->get();
        $volunteers = Volunteer::orderBy('name')->get();
        return view('attendance.create', compact('projects','volunteers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => ['required','integer','exists:projects,id'],
            'volunteer_id' => ['required','integer','exists:volunteers,id'],
            'check_in' => ['nullable','date'],
            'check_out' => ['nullable','date','after_or_equal:check_in'],
            'status' => ['required','in:present,absent,excused'],
            'notes' => ['nullable','string'],
        ]);
        Attendance::create($data);
        return redirect()->route('attendance.index')->with('status', 'Attendance recorded');
    }

    public function edit(Attendance $attendance)
    {
        $projects = Project::orderBy('title')->get();
        $volunteers = Volunteer::orderBy('name')->get();
        return view('attendance.edit', compact('attendance','projects','volunteers'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $data = $request->validate([
            'project_id' => ['required','integer','exists:projects,id'],
            'volunteer_id' => ['required','integer','exists:volunteers,id'],
            'check_in' => ['nullable','date'],
            'check_out' => ['nullable','date','after_or_equal:check_in'],
            'status' => ['required','in:present,absent,excused'],
            'notes' => ['nullable','string'],
        ]);
        $attendance->update($data);
        return redirect()->route('attendance.index')->with('status', 'Attendance updated');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return back()->with('status', 'Attendance deleted');
    }

    // Volunteer self-view
    public function myAttendance()
    {
        $user = Auth::user();
        $volunteer = Volunteer::where('user_id', $user->id)->first();
        $attendances = Attendance::with('project')->where('volunteer_id', optional($volunteer)->id)->latest()->paginate(15);
        return view('attendance.my', compact('attendances'));
    }
}


