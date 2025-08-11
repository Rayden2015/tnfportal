@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('messages.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block font-semibold">Channel</label>
            <select name="channel" class="border rounded p-2 w-full">
                <option value="mail">Email</option>
                <option value="sms">SMS</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Subject (Email only)</label>
            <input type="text" name="subject" class="border rounded p-2 w-full" />
        </div>

        <div>
            <label class="block font-semibold">Body</label>
            <textarea name="body" class="border rounded p-2 w-full" rows="5"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <h3 class="font-semibold mb-2">Volunteers</h3>
                <select name="volunteer_ids[]" multiple class="border rounded p-2 w-full h-40">
                    @foreach($volunteers as $v)
                        <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->email ?? $v->phone }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Donors</h3>
                <select name="donor_ids[]" multiple class="border rounded p-2 w-full h-40">
                    @foreach($donors as $d)
                        <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->email ?? $d->phone }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Project</h3>
                <select name="project_id" class="border rounded p-2 w-full">
                    <option value="">-- None --</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}">{{ $p->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <h3 class="font-semibold mb-2">Single Recipient (optional)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="email" name="recipient_email" placeholder="Email" class="border rounded p-2 w-full" />
                <input type="text" name="recipient_phone" placeholder="Phone" class="border rounded p-2 w-full" />
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Send</button>
    </form>
</div>
@endsection


