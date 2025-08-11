@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-4">New Donor</h1>
<form method="POST" action="{{ route('donors.store') }}" class="space-y-3">
    @csrf
    <input class="border p-2 w-full" name="name" placeholder="Name" />
    <input class="border p-2 w-full" name="email" placeholder="Email" />
    <input class="border p-2 w-full" name="phone" placeholder="Phone" />
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection


