@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">New Donation</h1>
<form method="POST" action="{{ route('donations.store') }}" class="space-y-3">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <select name="donor_id" class="border p-2 w-full">
            <option value="">-- Donor --</option>
            @foreach($donors as $donor)
                <option value="{{ $donor->id }}">{{ $donor->name }}</option>
            @endforeach
        </select>
        <select name="project_id" class="border p-2 w-full">
            <option value="">-- Project --</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->title }}</option>
            @endforeach
        </select>
        <input name="amount" placeholder="Amount" class="border p-2 w-full" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <input name="currency" value="GHS" class="border p-2 w-full" />
        <input name="payment_method" placeholder="Payment method" class="border p-2 w-full" />
        <select name="status" class="border p-2 w-full">
            @foreach(['pending','completed','refunded'] as $status)
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection


