<?php

namespace App\Http\Controllers;

use App\Models\DueCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DueCategoryController extends Controller
{
    public function index()
    {
        $categories = DueCategory::with(['creator', 'updater'])
            ->orderBy('name')
            ->get();
            
        return view('dues.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:due_categories,name',
            'due_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            DueCategory::create([
                'name' => $validated['name'],
                'due_amount' => $validated['due_amount'],
                'description' => $validated['description'] ?? null,
                'created_by' => auth()->id()
            ]);

            DB::commit();

            return back()->with('success', 'Due category created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating category: ' . $e->getMessage());
        }
    }

    public function show(DueCategory $dueCategory)
    {
        $dueCategory->load(['creator', 'updater']);
        return view('dues.categories-show', compact('dueCategory'));
    }

    public function update(Request $request, DueCategory $dueCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:due_categories,name,' . $dueCategory->id,
            'due_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $dueCategory->update([
                'name' => $validated['name'],
                'due_amount' => $validated['due_amount'],
                'description' => $validated['description'] ?? null,
                'updated_by' => auth()->id()
            ]);

            DB::commit();

            return back()->with('success', 'Due category updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating category: ' . $e->getMessage());
        }
    }

    public function destroy(DueCategory $dueCategory)
    {
        try {
            // Check if category is being used in dues payments
            if ($dueCategory->duesPayments()->exists()) {
                return back()->with('error', 'Cannot delete category. It has existing dues payments.');
            }

            DB::beginTransaction();

            $dueCategory->delete();

            DB::commit();

            return back()->with('success', 'Due category deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}