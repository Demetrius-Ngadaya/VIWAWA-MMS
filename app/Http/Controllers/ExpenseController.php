<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use Illuminate\Http\Request;
class ExpenseController extends Controller
{
    public function index(Request $r)
    {
        $q = Expense::query()
            ->when($r->filled('category'), fn($x)=>$x->where('category',$r->category))
            ->when($r->filled('from'), fn($x)=>$x->whereDate('spent_at','>=',$r->from))
            ->when($r->filled('to'), fn($x)=>$x->whereDate('spent_at','<=',$r->to))
            ->orderByDesc('spent_at');
        $expenses = $q->paginate(20)->withQueryString();
        return view('expenses.index', compact('expenses'));
    }

    public function create(){ return view('expenses.create'); }

    public function store(Request $r)
    {
        $d = $r->validate(['category'=>'required','amount'=>'required|numeric|min:0','spent_at'=>'required|date','description'=>'nullable']);
        Expense::create($d + ['created_by'=>auth()->id()]);
        return redirect()->route('expenses.index')->with('ok','Recorded');
    }

    public function destroy(Expense $expense){ $expense->delete(); return back()->with('ok','Deleted'); }
}