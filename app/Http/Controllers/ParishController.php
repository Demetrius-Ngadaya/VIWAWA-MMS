<?php

namespace App\Http\Controllers;

use App\Models\Parish;
use App\Models\Diocese;
use Illuminate\Http\Request;

class ParishController extends Controller
{
    public function index()
    {
        $parishes = Parish::with('diocese')->get();
        return view('parishes.index', compact('parishes'));
    }

    public function create()
    {
        $dioceses = Diocese::all();
        return view('parishes.create', compact('dioceses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'diocese_id' => 'required|exists:dioceses,id',
        ]);
        Parish::create($request->all());
        return redirect()->route('parishes.index')->with('success', 'Parish created successfully.');
    }

    public function show(Parish $parish)
    {
        return view('parishes.show', compact('parish'));
    }

    public function edit(Parish $parish)
    {
        $dioceses = Diocese::all();
        return view('parishes.edit', compact('parish', 'dioceses'));
    }

    public function update(Request $request, Parish $parish)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'diocese_id' => 'required|exists:dioceses,id',
        ]);
        $parish->update($request->all());
        return redirect()->route('parishes.index')->with('success', 'Parish updated successfully.');
    }

    public function destroy(Parish $parish)
    {
        $parish->delete();
        return redirect()->route('parishes.index')->with('success', 'Parish deleted successfully.');
    }
}

