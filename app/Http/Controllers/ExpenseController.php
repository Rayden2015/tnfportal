<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('project')->latest()->paginate(15);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $projects = Project::orderBy('title')->get();
        return view('expenses.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => ['nullable','integer','exists:projects,id'],
            'amount' => ['required','numeric','min:0'],
            'description' => ['nullable','string'],
        ]);
    $data['tenant_id'] = Auth::user()->tenant_id;
    $expense = Expense::create($data);
    \App\Http\Controllers\AuditController::logActivity($request, ['expense_id' => $expense->id], 'created');
    return redirect()->route('expenses.index')->with('status', 'Expense recorded');
    }

    public function edit(Expense $expense)
    {
        $projects = Project::orderBy('title')->get();
        return view('expenses.edit', compact('expense','projects'));
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'project_id' => ['nullable','integer','exists:projects,id'],
            'amount' => ['required','numeric','min:0'],
            'description' => ['nullable','string'],
        ]);
    $data['tenant_id'] = Auth::user()->tenant_id;
    $expense->update($data);
    \App\Http\Controllers\AuditController::logActivity($request, ['expense_id' => $expense->id], 'updated');
    return redirect()->route('expenses.index')->with('status', 'Expense updated');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        \App\Http\Controllers\AuditController::logActivity(request(), ['expense_id' => $expense->id], 'deleted');
        return back()->with('status', 'Expense deleted');
    }
}


