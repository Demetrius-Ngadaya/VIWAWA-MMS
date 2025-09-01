<?php

namespace App\Http\Controllers;

use App\Models\{DuesPayment, DueCategory, Member};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DuesPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = DuesPayment::with(['member', 'category', 'recordedBy', 'createdBy'])
            ->when($request->filled('category_id'), fn($q) => $q->where('due_category_id', $request->category_id))
            ->when($request->filled('member_id'), fn($q) => $q->where('member_id', $request->member_id))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('from'), fn($q) => $q->whereDate('paid_at', '>=', $request->from))
            ->when($request->filled('to'), fn($q) => $q->whereDate('paid_at', '<=', $request->to))
            ->orderByDesc('paid_at');

        $duesPayments = $query->paginate(20)->withQueryString();
        
        return view('dues.index', [
            'duesPayments' => $duesPayments,
            'members' => Member::with('user')->where('status', 'active')->orderBy('last_name')->get(),
            'categories' => DueCategory::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return view('dues.create', [
            'members' => Member::with('user')->where('status', 'active')->orderBy('last_name')->get(),
            'categories' => DueCategory::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'due_category_id' => 'required|exists:due_categories,id',
            'paid_amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // Get the required due amount
            $category = DueCategory::findOrFail($validated['due_category_id']);
            $requiredAmount = $category->due_amount;

            // Calculate payment status using the model method
            $duesPayment = new DuesPayment();
            $paymentStatus = $duesPayment->calculatePaymentStatus($validated['paid_amount'], $requiredAmount);

            // Create the dues payment
            DuesPayment::create([
                'member_id' => $validated['member_id'],
                'due_category_id' => $validated['due_category_id'],
                'paid_amount' => $validated['paid_amount'],
                'remaining_amount' => $paymentStatus['remaining_amount'],
                'exceeded_amount' => $paymentStatus['exceeded_amount'],
                'status' => $paymentStatus['status'],
                'recorded_by' => auth()->id(),
                'created_by' => auth()->id(),
                'paid_at' => $validated['paid_at'],
                'reference' => $validated['reference'] ?? null,
                'notes' => $validated['notes'] ?? null
            ]);

            DB::commit();

            return redirect()->route('dues.index')
                ->with('success', 'Due payment recorded successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error recording due payment: ' . $e->getMessage());
        }
    }

    public function show(DuesPayment $duesPayment)
    {
        $duesPayment->load(['member', 'category', 'recordedBy', 'createdBy', 'updatedBy']);
        return view('dues.show', compact('duesPayment'));
    }

    public function edit(DuesPayment $duesPayment)
    {
        $duesPayment->load(['member', 'category']);
        return view('dues.edit', [
            'duesPayment' => $duesPayment,
            'members' => Member::with('user')->where('status', 'active')->orderBy('last_name')->get(),
            'categories' => DueCategory::orderBy('name')->get()
        ]);
    }

    public function update(Request $request, DuesPayment $duesPayment)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'due_category_id' => 'required|exists:due_categories,id',
            'paid_amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // Get the required due amount
            $category = DueCategory::findOrFail($validated['due_category_id']);
            $requiredAmount = $category->due_amount;

            // Calculate payment status
            $paymentStatus = $duesPayment->calculatePaymentStatus($validated['paid_amount'], $requiredAmount);

            // Update the dues payment
            $duesPayment->update([
                'member_id' => $validated['member_id'],
                'due_category_id' => $validated['due_category_id'],
                'paid_amount' => $validated['paid_amount'],
                'remaining_amount' => $paymentStatus['remaining_amount'],
                'exceeded_amount' => $paymentStatus['exceeded_amount'],
                'status' => $paymentStatus['status'],
                'updated_by' => auth()->id(),
                'paid_at' => $validated['paid_at'],
                'reference' => $validated['reference'] ?? null,
                'notes' => $validated['notes'] ?? null
            ]);

            DB::commit();

            return redirect()->route('dues.index')
                ->with('success', 'Due payment updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating due payment: ' . $e->getMessage());
        }
    }

    public function destroy(DuesPayment $duesPayment)
    {
        try {
            DB::beginTransaction();

            $duesPayment->delete();

            DB::commit();

            return redirect()->route('dues.index')
                ->with('success', 'Due payment deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting due payment: ' . $e->getMessage());
        }
    }

    // Get member's due payment summary
    public function getMemberSummary($memberId, $categoryId)
    {
        $totalPaid = DuesPayment::where('member_id', $memberId)
            ->where('due_category_id', $categoryId)
            ->sum('paid_amount');

        $category = DueCategory::find($categoryId);
        $requiredAmount = $category ? $category->due_amount : 0;

        return response()->json([
            'total_paid' => $totalPaid,
            'required_amount' => $requiredAmount,
            'remaining_amount' => max(0, $requiredAmount - $totalPaid)
        ]);
    }
}