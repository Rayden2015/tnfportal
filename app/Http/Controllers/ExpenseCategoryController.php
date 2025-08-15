<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::where('tenant_id', Auth::user()->tenant_id)->get();
        return view('expense_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('expense_categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $data['tenant_id'] = Auth::user()->tenant_id;
        ExpenseCategory::create($data);
        activity()->performedOn(new ExpenseCategory($data))->causedBy(Auth::user())->withProperties(['request' => $request->all()])->log('Expense category created');
        return redirect()->route('expense_categories.index')->with('status', 'Category created');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('expense_categories.edit', compact('expenseCategory'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $expenseCategory->update($data);
        activity()->performedOn($expenseCategory)->causedBy(Auth::user())->withProperties(['request' => $request->all()])->log('Expense category updated');
        return redirect()->route('expense_categories.index')->with('status', 'Category updated');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        activity()->performedOn($expenseCategory)->causedBy(Auth::user())->log('Expense category deleted');
        return back()->with('status', 'Category deleted');
    }
}
