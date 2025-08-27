<?php

namespace App\Http\Controllers;

use App\Models\{Contribution, ContributionCategory, Member};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ContributionController extends Controller
{
    public function index(Request $request)
    {
        $query = Contribution::with(['member', 'category', 'recordedBy', 'createdBy'])
            ->when($request->filled('category_id'), fn($q) => $q->where('contribution_category_id', $request->category_id))
            ->when($request->filled('member_id'), fn($q) => $q->where('member_id', $request->member_id))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('from'), fn($q) => $q->whereDate('contributed_at', '>=', $request->from))
            ->when($request->filled('to'), fn($q) => $q->whereDate('contributed_at', '<=', $request->to))
            ->orderByDesc('contributed_at');

        $contributions = $query->paginate(20)->withQueryString();
        
        return view('contributions.index', [
            'contributions' => $contributions,
            'members' => Member::with('user')->where('status', 'active')->orderBy('last_name')->get(),
            'categories' => ContributionCategory::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return view('contributions.create', [
            'members' => Member::with('user')->where('status', 'active')->orderBy('last_name')->get(),
            'categories' => ContributionCategory::orderBy('name')->get()
        ]);
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'member_id' => 'required|exists:members,id',
        'contribution_category_id' => 'required|exists:contribution_categories,id',
        'paid_amount' => 'required|numeric|min:0',
        'contributed_at' => 'required|date',
        'reference' => 'nullable|string|max:255',
        'notes' => 'nullable|string|max:1000'
    ]);

    try {
        DB::beginTransaction();

        // Get the required contribution amount
        $category = ContributionCategory::findOrFail($validated['contribution_category_id']);
        $requiredAmount = $category->contribution_amount;

        // Calculate payment status using the model method
        $contribution = new Contribution();
        $paymentStatus = $contribution->calculatePaymentStatus($validated['paid_amount'], $requiredAmount);

        // Create the contribution
        Contribution::create([
            'member_id' => $validated['member_id'],
            'contribution_category_id' => $validated['contribution_category_id'],
            'paid_amount' => $validated['paid_amount'],
            'remaining_amount' => $paymentStatus['remaining_amount'],
            'exceeded_amount' => $paymentStatus['exceeded_amount'],
            'status' => $paymentStatus['status'],
            'recorded_by' => auth()->id(),
            'created_by' => auth()->id(),
            'contributed_at' => $validated['contributed_at'],
            'reference' => $validated['reference'] ?? null,
            'notes' => $validated['notes'] ?? null
        ]);

        DB::commit();

        return redirect()->route('contributions.index')
            ->with('success', 'Contribution recorded successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->with('error', 'Error recording contribution: ' . $e->getMessage());
    }
}

    public function show(Contribution $contribution)
    {
        $contribution->load(['member', 'category', 'recordedBy', 'createdBy', 'updatedBy']);
        return view('contributions.show', compact('contribution'));
    }

    public function edit(Contribution $contribution)
    {
        $contribution->load(['member', 'category']);
        return view('contributions.edit', [
            'contribution' => $contribution,
            'members' => Member::with('user')->where('status', 'active')->orderBy('last_name')->get(),
            'categories' => ContributionCategory::orderBy('name')->get()
        ]);
    }

    public function update(Request $request, Contribution $contribution)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'contribution_category_id' => 'required|exists:contribution_categories,id',
            'paid_amount' => 'required|numeric|min:0',
            'contributed_at' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // Get the required contribution amount
            $category = ContributionCategory::findOrFail($validated['contribution_category_id']);
            $requiredAmount = $category->contribution_amount;

            // Calculate payment status
            $paymentStatus = $contribution->calculatePaymentStatus($validated['paid_amount'], $requiredAmount);

            // Update the contribution
            $contribution->update([
                'member_id' => $validated['member_id'],
                'contribution_category_id' => $validated['contribution_category_id'],
                'paid_amount' => $validated['paid_amount'],
                'remaining_amount' => $paymentStatus['remaining_amount'],
                'exceeded_amount' => $paymentStatus['exceeded_amount'],
                'status' => $paymentStatus['status'],
                'updated_by' => auth()->id(),
                'contributed_at' => $validated['contributed_at'],
                'reference' => $validated['reference'] ?? null,
                'notes' => $validated['notes'] ?? null
            ]);

            DB::commit();

            return redirect()->route('contributions.index')
                ->with('success', 'Contribution updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating contribution: ' . $e->getMessage());
        }
    }

    public function destroy(Contribution $contribution)
    {
        try {
            DB::beginTransaction();

            $contribution->delete();

            DB::commit();

            return redirect()->route('contributions.index')
                ->with('success', 'Contribution deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting contribution: ' . $e->getMessage());
        }
    }

    // Get member's contribution summary
    public function getMemberSummary($memberId, $categoryId)
    {
        $totalPaid = Contribution::where('member_id', $memberId)
            ->where('contribution_category_id', $categoryId)
            ->sum('paid_amount');

        $category = ContributionCategory::find($categoryId);
        $requiredAmount = $category ? $category->contribution_amount : 0;

        return response()->json([
            'total_paid' => $totalPaid,
            'required_amount' => $requiredAmount,
            'remaining_amount' => max(0, $requiredAmount - $totalPaid)
        ]);
    }
}