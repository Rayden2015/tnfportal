@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">New Donor</h1>
    <form method="POST" action="{{ route('donors.store') }}" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="name" placeholder="Name" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="email" placeholder="Email" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
            <input class="border rounded-lg p-2 w-full focus:ring focus:ring-blue-200" name="phone" placeholder="Phone" />
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Save</button>
    </form>
</div>
@endsection


