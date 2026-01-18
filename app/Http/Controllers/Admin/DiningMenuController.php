<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiningMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = \App\Models\DiningMenu::all();
        return view('admin.dining-menu.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dining-menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        \App\Models\DiningMenu::create($validated);

        return redirect()->route('admin.dining-menu.index')->with('success', 'Menu created successfully.');
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
        $item = \App\Models\DiningMenu::findOrFail($id);
        return view('admin.dining-menu.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $item = \App\Models\DiningMenu::findOrFail($id);
        $item->update($validated);

        return redirect()->route('admin.dining-menu.index')->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = \App\Models\DiningMenu::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.dining-menu.index')->with('success', 'Menu deleted successfully.');
    }
}
