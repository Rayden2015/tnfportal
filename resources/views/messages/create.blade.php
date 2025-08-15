@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('messages.store') }}" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Channel</label>
            <select name="channel" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                <option value="mail">Email</option>
                <option value="sms">SMS</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Template (optional)</label>
            <select name="template_id" id="template_id" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                <option value="">-- Select Template --</option>
                @foreach(($templates ?? []) as $template)
                    <option value="{{ $template->id }}" data-body="{{ e($template->body) }}">
                        {{ $template->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Subject (Email only)</label>
            <input type="text" name="subject" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Body</label>
            <textarea name="body" id="body" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" rows="5"></textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <h3 class="font-semibold mb-2">Volunteers</h3>
                <select name="volunteer_ids[]" multiple class="border rounded-lg p-2 w-full h-40 focus:ring focus:ring-blue-200">
                    @foreach($volunteers as $v)
                        <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->email ?? $v->phone }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Donors</h3>
                <select name="donor_ids[]" multiple class="border rounded-lg p-2 w-full h-40 focus:ring focus:ring-blue-200">
                    @foreach($donors as $d)
                        <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->email ?? $d->phone }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Project</h3>
                <select name="project_id" class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
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

<script>
document.getElementById('template_id').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const body = selected.getAttribute('data-body') || '';
    document.getElementById('body').value = body;
});
</script>
@endsection
