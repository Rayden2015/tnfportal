@extends('layouts.app')
@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Projects</h1>
    <a href="{{ route('projects.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">New Project</a>
  </div>
<table class="w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2 text-left">Title</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2 text-left">Dates</th>
            <th class="p-2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            <tr class="border-t">
                <td class="p-2">{{ $project->title }}</td>
                <td class="p-2">{{ $project->status }}</td>
                <td class="p-2">{{ $project->start_date }} - {{ $project->end_date }}</td>
                <td class="p-2 text-right">
                    <a href="{{ route('projects.edit', $project) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete project?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $projects->links() }}</div>
@endsection


