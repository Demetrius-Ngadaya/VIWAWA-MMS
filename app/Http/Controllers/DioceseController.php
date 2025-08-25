<?php

namespace App\Http\Controllers;
use App\Models\Diocese;
use Illuminate\Http\Request;

class DioceseController extends Controller
{
    public function index()
    {
        $dioceses = Diocese::all();
        return view('dioceses.index', compact('dioceses'));
    }

    public function create()
    {
        return view('dioceses.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Diocese::create($request->all());
        return redirect()->route('dioceses.index')->with('success', 'Diocese created successfully.');
    }

    public function show(Diocese $diocese)
    {
        return view('dioceses.show', compact('diocese'));
    }

    public function edit(Diocese $diocese)
    {
        return view('dioceses.edit', compact('diocese'));
    }

    public function update(Request $request, Diocese $diocese)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $diocese->update($request->all());
        return redirect()->route('dioceses.index')->with('success', 'Diocese updated successfully.');
    }

    public function destroy(Diocese $diocese)
    {
        $diocese->delete();
        return redirect()->route('dioceses.index')->with('success', 'Diocese deleted successfully.');
    }
}
