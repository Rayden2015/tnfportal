<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
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
        \Log::debug('DonationController@store: validated data', $data);
        $data['tenant_id'] = Auth::user()->tenant_id;
        $donation = Donation::create($data);
        \Log::info('DonationController@store: Donation created', ['donation_id' => $donation->id, 'data' => $data]);

        // Send thank you message to donor via email and SMS using Thank You template
        $donor = Donor::find($data['donor_id']);
        if ($donor) {
            $template = \App\Models\MessageTemplate::where('name', 'Thank You')->where('tenant_id', $data['tenant_id'])->first();
            if ($template) {
                $subject = $template->subject ?? 'Thank You';
                $body = $template->body ?? 'Thank you for your donation!';
                // Personalize body
                if (isset($donor->name)) {
                    $nameParts = explode(' ', trim($donor->name));
                    $firstName = $nameParts[0] ?? '';
                    $lastName = $nameParts[1] ?? '';
                    $body = str_replace('{first_name}', $firstName, $body);
                    $body = str_replace('{last_name}', $lastName, $body);
                }
                \Log::info('DonationController@store: Sending thank you notification', ['donor_id' => $donor->id, 'subject' => $subject, 'body' => $body]);
                // Send email
                $donor->notify(new \App\Notifications\GenericMessage($subject, $body, 'mail'));
                // Send SMS
                $donor->notify(new \App\Notifications\GenericMessage($subject, $body, 'sms'));
            } else {
                \Log::warning('DonationController@store: Thank You template not found', ['tenant_id' => $data['tenant_id']]);
            }
        } else {
            \Log::warning('DonationController@store: Donor not found', ['donor_id' => $data['donor_id']]);
        }
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
    $data['tenant_id'] = Auth::user()->tenant_id;
    $donation->update($data);
        return redirect()->route('donations.index')->with('status', 'Donation updated');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return back()->with('status', 'Donation deleted');
    }
}


