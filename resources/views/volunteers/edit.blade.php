@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">Edit Volunteer</h1>
<form method="POST" action="{{ route('volunteers.update', $volunteer) }}" class="space-y-3">
    @csrf
    @method('PUT')
    <input class="border p-2 w-full" name="name" value="{{ old('name', $volunteer->name) }}" />
    <input class="border p-2 w-full" name="email" value="{{ old('email', $volunteer->email) }}" />
    <input class="border p-2 w-full" name="phone" value="{{ old('phone', $volunteer->phone) }}" />
    <textarea class="border p-2 w-full" name="notes">{{ old('notes', $volunteer->notes) }}</textarea>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection


