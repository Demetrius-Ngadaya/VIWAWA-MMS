<?php

namespace App\Http\Controllers;

use App\Models\ContributionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContributionCategoryController extends Controller
{
    public function index()
    {
        $categories = ContributionCategory::with(['creator', 'updater'])
            ->orderBy('name')
            ->get();
            
        return view('contributions.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:contribution_categories,name',
            'contribution_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            ContributionCategory::create([
                'name' => $validated['name'],
                'contribution_amount' => $validated['contribution_amount'],
                'description' => $validated['description'] ?? null,
                'created_by' => auth()->id()
            ]);

            DB::commit();

            return back()->with('success', 'Contribution category created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating category: ' . $e->getMessage());
        }
    }

    public function show(ContributionCategory $contributionCategory)
    {
        $contributionCategory->load(['creator', 'updater']);
        return view('contributions.categories-show', compact('contributionCategory'));
    }

    public function update(Request $request, ContributionCategory $contributionCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:contribution_categories,name,' . $contributionCategory->id,
            'contribution_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $contributionCategory->update([
                'name' => $validated['name'],
                'contribution_amount' => $validated['contribution_amount'],
                'description' => $validated['description'] ?? null,
                'updated_by' => auth()->id()
            ]);

            DB::commit();

            return back()->with('success', 'Contribution category updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating category: ' . $e->getMessage());
        }
    }

    public function destroy(ContributionCategory $contributionCategory)
    {
        try {
            // Check if category is being used in contributions
            if ($contributionCategory->contributions()->exists()) {
                return back()->with('error', 'Cannot delete category. It has existing contributions.');
            }

            DB::beginTransaction();

            $contributionCategory->delete();

            DB::commit();

            return back()->with('success', 'Contribution category deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}