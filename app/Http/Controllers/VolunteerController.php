<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index()
    {
        $volunteers = Volunteer::latest()->paginate(15);
        return view('volunteers.index', compact('volunteers'));
    }

    public function create()
    {
        return view('volunteers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['nullable','email'],
            'phone' => ['nullable','string','max:30'],
            'notes' => ['nullable','string'],
        ]);
    $data['tenant_id'] = Auth::user()->tenant_id;
    $volunteer = Volunteer::create($data);
    \App\Http\Controllers\AuditController::logActivity($request, ['volunteer_id' => $volunteer->id], 'created');
    return redirect()->route('volunteers.index')->with('status', 'Volunteer created');
    }

    public function edit(Volunteer $volunteer)
    {
        return view('volunteers.edit', compact('volunteer'));
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['nullable','email'],
            'phone' => ['nullable','string','max:30'],
            'notes' => ['nullable','string'],
        ]);
    $data['tenant_id'] = Auth::user()->tenant_id;
    $volunteer->update($data);
    \App\Http\Controllers\AuditController::logActivity($request, ['volunteer_id' => $volunteer->id], 'updated');
    return redirect()->route('volunteers.index')->with('status', 'Volunteer updated');
    }

    public function destroy(Volunteer $volunteer)
    {
    $volunteer->delete();
    \App\Http\Controllers\AuditController::logActivity(request(), ['volunteer_id' => $volunteer->id], 'deleted');
    return back()->with('status', 'Volunteer deleted');
    }
}


