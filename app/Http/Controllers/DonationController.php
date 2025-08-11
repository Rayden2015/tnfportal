<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\Project;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with(['donor','project'])->latest()->paginate(15);
        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        $donors = Donor::orderBy('name')->get();
        $projects = Project::orderBy('title')->get();
        return view('donations.create', compact('donors','projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'donor_id' => ['nullable','integer','exists:donors,id'],
            'project_id' => ['nullable','integer','exists:projects,id'],
            'amount' => ['required','numeric','min:0'],
            'currency' => ['required','string','max:10'],
            'payment_method' => ['nullable','string','max:50'],
            'status' => ['required','in:pending,completed,refunded'],
        ]);
        Donation::create($data);
        return redirect()->route('donations.index')->with('status', 'Donation recorded');
    }

    public function edit(Donation $donation)
    {
        $donors = Donor::orderBy('name')->get();
        $projects = Project::orderBy('title')->get();
        return view('donations.edit', compact('donation','donors','projects'));
    }

    public function update(Request $request, Donation $donation)
    {
        $data = $request->validate([
            'donor_id' => ['nullable','integer','exists:donors,id'],
            'project_id' => ['nullable','integer','exists:projects,id'],
            'amount' => ['required','numeric','min:0'],
            'currency' => ['required','string','max:10'],
            'payment_method' => ['nullable','string','max:50'],
            'status' => ['required','in:pending,completed,refunded'],
        ]);
        $donation->update($data);
        return redirect()->route('donations.index')->with('status', 'Donation updated');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return back()->with('status', 'Donation deleted');
    }
}


