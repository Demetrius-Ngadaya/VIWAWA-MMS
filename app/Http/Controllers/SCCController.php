<?php
namespace App\Http\Controllers;

use App\Models\SCC;
use App\Models\Parish;
use Illuminate\Http\Request;

class SCCController extends Controller
{
    public function index()
    {
        $sccs = SCC::with('parish')->get();
        return view('sccs.index', compact('sccs'));
    }

    public function create()
    {
        $parishes = Parish::all();
        return view('sccs.create', compact('parishes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parish_id' => 'required|exists:parishes,id',
        ]);
        SCC::create($request->all());
        return redirect()->route('sccs.index')->with('success', 'SCC created successfully.');
    }

    public function show(SCC $scc)
    {
        return view('sccs.show', compact('scc'));
    }

    public function edit(SCC $scc)
    {
        $parishes = Parish::all();
        return view('sccs.edit', compact('scc', 'parishes'));
    }

    public function update(Request $request, SCC $scc)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parish_id' => 'required|exists:parishes,id',
        ]);
        $scc->update($request->all());
        return redirect()->route('sccs.index')->with('success', 'SCC updated successfully.');
    }

    public function destroy(SCC $scc)
    {
        $scc->delete();
        return redirect()->route('sccs.index')->with('success', 'SCC deleted successfully.');
    }
}
