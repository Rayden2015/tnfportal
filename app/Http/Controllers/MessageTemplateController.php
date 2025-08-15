<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplate;
use Illuminate\Http\Request;

class MessageTemplateController extends Controller
{
    public function index()
    {
        $templates = MessageTemplate::all();
        return view('message_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('message_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $template = MessageTemplate::create([
            'name' => $request->name,
            'body' => $request->body,
            'tenant_id' => $request->user()->tenant_id ?? null,
        ]);
        \App\Http\Controllers\AuditController::logActivity($request, ['template_id' => $template->id], 'created');
        return redirect()->route('message_templates.index')->with('success', 'Template created successfully.');
    }

    public function show(MessageTemplate $messageTemplate)
    {
        return view('message_templates.show', compact('messageTemplate'));
    }

    public function edit(MessageTemplate $messageTemplate)
    {
        return view('message_templates.edit', compact('messageTemplate'));
    }

    public function update(Request $request, MessageTemplate $messageTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $messageTemplate->update([
            'name' => $request->name,
            'body' => $request->body,
        ]);
        \App\Http\Controllers\AuditController::logActivity($request, ['template_id' => $messageTemplate->id], 'updated');
        return redirect()->route('message_templates.index')->with('success', 'Template updated successfully.');
    }

    public function destroy(MessageTemplate $messageTemplate)
    {
        $messageTemplate->delete();

        return redirect()->route('message_templates.index')->with('success', 'Template deleted successfully.');
    }
}
