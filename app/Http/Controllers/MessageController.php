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
use Illuminate\Support\Facades\Notification;
use App\Models\MessageTemplate;


class MessageController extends Controller
{
    public function create()
    {
        $volunteers = class_exists(Volunteer::class) ? Volunteer::query()->select('id','name','email','phone')->get() : collect();
        $donors = class_exists(Donor::class) ? Donor::query()->select('id','name','email','phone')->get() : collect();
        $projects = class_exists(Project::class) ? Project::query()->select('id','title')->get() : collect();
        $templates = class_exists(MessageTemplate::class) ? MessageTemplate::query()->select('id','name','body')->get() : collect();
        return view('messages.create', compact('volunteers','donors','projects', 'templates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
                'subject' => ['nullable','string','max:255'],
                'body' => ['nullable','string'],
                'channel' => ['required','in:mail,sms'],
                'volunteer_ids' => ['array'],
                'donor_ids' => ['array'],
                'project_id' => ['nullable','integer'],
                'recipient_email' => ['nullable','email'],
                'recipient_phone' => ['nullable','string','max:30'],
                'template_id' => ['nullable','integer'],
            ]);

        $data['tenant_id'] = Auth::user()->tenant_id;
        $notifiables = collect();
        Log::debug('MessageController@store: validated data', $data);

        if (!empty($data['template_id'])) {
            $template = MessageTemplate::find($data['template_id']);
            if ($template) {
                $data['subject'] = $template->subject ?? $data['subject'] ?? '';
                // Only fill body from template if body is empty or not provided
                if (empty($data['body'])) {
                    $data['body'] = $template->body ?? '';
                }
            }
        }

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

        Log::debug('MessageController@store: notifiables to notify', $notifiables->toArray());

        try {
            foreach ($notifiables as $notifiable) {
                $personalizedBody = $data['body'] ?? '';
                if (isset($notifiable->name)) {
                    $nameParts = explode(' ', trim($notifiable->name));
                    $firstName = $nameParts[0] ?? '';
                    $lastName = $nameParts[1] ?? '';
                    $personalizedBody = str_replace('{first_name}', $firstName, $personalizedBody);
                    $personalizedBody = str_replace('{last_name}', $lastName, $personalizedBody);
                }
                $notification = new GenericMessage($data['subject'] ?? '', $personalizedBody, $data['channel']);
                Log::debug('MessageController@store: notifying', ['notifiable' => (array) $notifiable]);
                Notification::send($notifiable, $notification);
                Message::create([
                    'tenant_id' => $data['tenant_id'],
                    'subject' => $data['subject'] ?? '',
                    'body' => $personalizedBody,
                    'channel' => $data['channel'],
                    'status' => 'sent',
                ]);
                \App\Http\Controllers\AuditController::logActivity($request, ['notifiable' => (array) $notifiable, 'subject' => $data['subject'] ?? '', 'channel' => $data['channel']], 'message-sent');
            }
        } catch (\Exception $e) {
            Log::error('MessageController@store: notification sending failed', ['error' => $e->getMessage()]);
            foreach ($notifiables as $notifiable) {
                Message::create([
                    'tenant_id' => $data['tenant_id'],
                    'subject' => $data['subject'] ?? '',
                    'body' => $data['body'],
                    'channel' => $data['channel'],
                    'status' => 'failed',
                ]);
                \App\Http\Controllers\AuditController::logActivity($request, ['notifiable' => (array) $notifiable, 'subject' => $data['subject'] ?? '', 'channel' => $data['channel'], 'error' => $e->getMessage()], 'message-failed');
            }
        }
        return redirect()->back()->with('status', 'Messages queued');
    }
}
