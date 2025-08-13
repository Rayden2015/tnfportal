<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Support\Facades\Log;
use App\Notifications\AdHocNotifiable;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Project;
use App\Models\Volunteer;
use App\Notifications\GenericMessage;
use Illuminate\Http\Request;
use App\Models\MessageLog;

class MessageController extends Controller
{
    public function create()
    {
        $volunteers = class_exists(Volunteer::class) ? Volunteer::query()->select('id','name','email','phone')->get() : collect();
        $donors = class_exists(Donor::class) ? Donor::query()->select('id','name','email','phone')->get() : collect();
        $projects = class_exists(Project::class) ? Project::query()->select('id','title')->get() : collect();
    return view('messages.create', compact('volunteers','donors','projects'));
    }

    public function store(Request $request)
    {
    $data = $request->validate([
            'subject' => ['nullable','string','max:255'],
            'body' => ['required','string'],
            'channel' => ['required','in:mail,sms'],
            'volunteer_ids' => ['array'],
            'donor_ids' => ['array'],
            'project_id' => ['nullable','integer'],
            'recipient_email' => ['nullable','email'],
            'recipient_phone' => ['nullable','string','max:30'],
        ]);

    $data['tenant_id'] = Auth::user()->tenant_id;
    $notifiables = collect();
    Log::debug('MessageController@store: validated data', $data);

        if ($request->filled('recipient_email') || $request->filled('recipient_phone')) {
            $recipient = new AdHocNotifiable($request->input('recipient_email'), $request->input('recipient_phone'));
            Log::debug('MessageController@store: direct recipient', ['email' => $recipient->email, 'phone' => $recipient->phone]);
            $notifiables->push($recipient);
        }

        if ($request->filled('volunteer_ids') && class_exists(Volunteer::class)) {
            $volunteers = Volunteer::query()->whereIn('id', $request->input('volunteer_ids', []))->get();
            Log::debug('MessageController@store: volunteer recipients', $volunteers->toArray());
            $notifiables = $notifiables->merge($volunteers);
        }
        if ($request->filled('donor_ids') && class_exists(Donor::class)) {
            $donors = Donor::query()->whereIn('id', $request->input('donor_ids', []))->get();
            Log::debug('MessageController@store: donor recipients', $donors->toArray());
            $notifiables = $notifiables->merge($donors);
        }
        if ($request->filled('project_id') && class_exists(Project::class)) {
            // You might notify all volunteers on a project; placeholder for later expansion
        }

        $notification = new GenericMessage($data['subject'] ?? '', $data['body']);
        Log::debug('MessageController@store: notifiables to notify', $notifiables->toArray());
        foreach ($notifiables as $notifiable) {
            Log::debug('MessageController@store: notifying', ['notifiable' => (array) $notifiable]);
            $notifiable->notify($notification);
        }

        return redirect()->back()->with('status', 'Messages queued');
    }
}


