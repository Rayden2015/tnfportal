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
        activity()
            ->performedOn($volunteer)
            ->causedBy(Auth::user())
            ->withProperties(['request' => $request->all()])
            ->log('Volunteer created');
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
        activity()
            ->performedOn($volunteer)
            ->causedBy(Auth::user())
            ->withProperties(['request' => $request->all()])
            ->log('Volunteer updated');
        return redirect()->route('volunteers.index')->with('status', 'Volunteer updated');
    }

    public function destroy(Volunteer $volunteer)
    {
        $volunteer->delete();
        activity()
            ->performedOn($volunteer)
            ->causedBy(Auth::user())
            ->withProperties(['request' => request()->all()])
            ->log('Volunteer deleted');
        return back()->with('status', 'Volunteer deleted');
    }
}


