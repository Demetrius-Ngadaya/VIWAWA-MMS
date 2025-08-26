<?php
namespace App\Http\Controllers;
use App\Models\Member;

use App\Models\{Diocese,Parish,SCC,Contribution,Expense};
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */


        public function index()
    {
        $members = Member::count();
        $contributionsThisMonth = Contribution::where('created_at', now()->format('Y-m'))->sum('paid_amount');
        $contribThisMonth = Contribution::whereMonth('contributed_at', now()->month)->whereYear('contributed_at', now()->year)->sum('paid_amount');
        $expensesThisMonth = Expense::whereMonth('spent_at', now()->month)->whereYear('spent_at', now()->year)->sum('amount');

        return view('dashboard', compact('members','contributionsThisMonth','contribThisMonth','expensesThisMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
