@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">Edit Donation</h1>
<form method="POST" action="{{ route('donations.update', $donation) }}" class="space-y-3">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <select name="donor_id" class="border p-2 w-full">
            <option value="">-- Donor --</option>
            @foreach($donors as $donor)
                <option value="{{ $donor->id }}" @selected(old('donor_id', $donation->donor_id) == $donor->id)>{{ $donor->name }}</option>
            @endforeach
        </select>
        <select name="project_id" class="border p-2 w-full">
            <option value="">-- Project --</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" @selected(old('project_id', $donation->project_id) == $project->id)>{{ $project->title }}</option>
            @endforeach
        </select>
        <input name="amount" value="{{ old('amount', $donation->amount) }}" class="border p-2 w-full" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <input name="currency" value="{{ old('currency', $donation->currency) }}" class="border p-2 w-full" />
        <input name="payment_method" value="{{ old('payment_method', $donation->payment_method) }}" class="border p-2 w-full" />
        <select name="status" class="border p-2 w-full">
            @foreach(['pending','completed','refunded'] as $status)
                <option value="{{ $status }}" @selected(old('status', $donation->status) === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection


