<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\ExpenseCategory;
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
        $categories = ExpenseCategory::where('tenant_id', Auth::user()->tenant_id)->orderBy('name')->get();
        return view('expenses.create', compact('projects', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => ['nullable','integer','exists:projects,id'],
            'expense_category_id' => ['required','integer','exists:expense_categories,id'],
            'amount' => ['required','numeric','min:0'],
            'description' => ['nullable','string'],
        ]);
        $data['tenant_id'] = Auth::user()->tenant_id;
        $expense = Expense::create($data);
        activity()
            ->performedOn($expense)
            ->causedBy(Auth::user())
            ->withProperties(['request' => $request->all()])
            ->log('Expense recorded');
        return redirect()->route('expenses.index')->with('status', 'Expense recorded');
    }

    public function edit(Expense $expense)
    {
        $projects = Project::orderBy('title')->get();
        $categories = ExpenseCategory::where('tenant_id', Auth::user()->tenant_id)->orderBy('name')->get();
        return view('expenses.edit', compact('expense','projects','categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'project_id' => ['nullable','integer','exists:projects,id'],
            'expense_category_id' => ['required','integer','exists:expense_categories,id'],
            'amount' => ['required','numeric','min:0'],
            'description' => ['nullable','string'],
        ]);
        $data['tenant_id'] = Auth::user()->tenant_id;
        $expense->update($data);
        activity()
            ->performedOn($expense)
            ->causedBy(Auth::user())
            ->withProperties(['request' => $request->all()])
            ->log('Expense updated');
        return redirect()->route('expenses.index')->with('status', 'Expense updated');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        activity()
            ->performedOn($expense)
            ->causedBy(Auth::user())
            ->withProperties(['request' => request()->all()])
            ->log('Expense deleted');
        return back()->with('status', 'Expense deleted');
    }
}


