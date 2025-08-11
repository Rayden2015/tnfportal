<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Message;
use App\Models\Project;
use App\Models\Volunteer;
use App\Notifications\GenericMessage;
use Illuminate\Http\Request;

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

        $notifiables = collect();

        if ($request->filled('recipient_email') || $request->filled('recipient_phone')) {
            $notifiables->push((object) [
                'email' => $request->input('recipient_email'),
                'phone' => $request->input('recipient_phone'),
                'routeNotificationForMail' => fn () => $request->input('recipient_email'),
                'routeNotificationForSms' => fn () => $request->input('recipient_phone'),
                'notify' => function ($notification) {
                    \Illuminate\Support\Facades\Notification::route('mail', $this->email)
                        ->route('sms', $this->phone)
                        ->notify($notification);
                },
            ]);
        }

        if ($request->filled('volunteer_ids') && class_exists(Volunteer::class)) {
            $notifiables = $notifiables->merge(Volunteer::query()->whereIn('id', $request->input('volunteer_ids', []))->get());
        }
        if ($request->filled('donor_ids') && class_exists(Donor::class)) {
            $notifiables = $notifiables->merge(Donor::query()->whereIn('id', $request->input('donor_ids', []))->get());
        }
        if ($request->filled('project_id') && class_exists(Project::class)) {
            // You might notify all volunteers on a project; placeholder for later expansion
        }

        $notification = new GenericMessage($data['subject'] ?? '', $data['body']);

        $channel = $data['channel'];
        foreach ($notifiables as $notifiable) {
            if ($channel === 'mail') {
                \Illuminate\Support\Facades\Notification::route('mail', $notifiable->email ?? null)->notify($notification);
            } else {
                \Illuminate\Support\Facades\Notification::route('sms', $notifiable->phone ?? null)->notify($notification);
            }
        }

        return redirect()->back()->with('status', 'Messages queued');
    }
}


