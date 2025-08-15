<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index()
    {
        $donors = Donor::latest()->paginate(15);
        return view('donors.index', compact('donors'));
    }

    public function create()
    {
        return view('donors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['nullable','email'],
            'phone' => ['nullable','string','max:30'],
        ]);
    $data['tenant_id'] = Auth::user()->tenant_id;
    $donor = Donor::create($data);
    activity()
        ->performedOn($donor)
        ->causedBy(Auth::user())
        ->withProperties(['request' => $request->all()])
        ->log('Donor created');
    return redirect()->route('donors.index')->with('status', 'Donor created');
    }

    public function edit(Donor $donor)
    {
        return view('donors.edit', compact('donor'));
    }

    public function update(Request $request, Donor $donor)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['nullable','email'],
            'phone' => ['nullable','string','max:30'],
            'tags' => ['required','string','max:255'],
        ]);
    $data['tenant_id'] = Auth::user()->tenant_id;
    $donor->update($data);
    activity()
        ->performedOn($donor)
        ->causedBy(Auth::user())
        ->withProperties(['request' => $request->all()])
        ->log('Donor updated');
    return redirect()->route('donors.index')->with('status', 'Donor updated');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();
        activity()
            ->performedOn($donor)
            ->causedBy(Auth::user())
            ->withProperties(['request' => request()->all()])
            ->log('Donor deleted');
        return back()->with('status', 'Donor deleted');
    }
}


