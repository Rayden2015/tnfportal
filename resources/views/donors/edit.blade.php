@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">Edit Donor</h1>
<form method="POST" action="{{ route('donors.update', $donor) }}" class="space-y-3">
    @csrf
    @method('PUT')
    <input class="border p-2 w-full" name="name" value="{{ old('name', $donor->name) }}" />
    <input class="border p-2 w-full" name="email" value="{{ old('email', $donor->email) }}" />
    <input class="border p-2 w-full" name="phone" value="{{ old('phone', $donor->phone) }}" />
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection


