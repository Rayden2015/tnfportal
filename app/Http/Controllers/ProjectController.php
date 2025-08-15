<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(15);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date','after_or_equal:start_date'],
            'status' => ['required','in:draft,active,completed,cancelled'],
        ]);
    $data['tenant_id'] = Auth::user()->tenant_id;
    $project = Project::create($data);
    activity()
        ->performedOn($project)
        ->causedBy(Auth::user())
        ->withProperties(['request' => $request->all()])
        ->log('Project created');
    return redirect()->route('projects.index')->with('status', 'Project created');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date','after_or_equal:start_date'],
            'status' => ['required','in:draft,active,completed,cancelled'],
        ]);
    $data['tenant_id'] = Auth::user()->tenant_id;
    $project->update($data);
    activity()
        ->performedOn($project)
        ->causedBy(Auth::user())
        ->withProperties(['request' => $request->all()])
        ->log('Project updated');
    return redirect()->route('projects.index')->with('status', 'Project updated');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        activity()
            ->performedOn($project)
            ->causedBy(Auth::user())
            ->withProperties(['request' => request()->all()])
            ->log('Project deleted');
        return back()->with('status', 'Project deleted');
    }

    // For volunteers
    public function volunteerIndex()
    {
        $projects = Project::where('status', 'active')->latest()->paginate(15);
        return view('projects.volunteer-index', compact('projects'));
    }
}


