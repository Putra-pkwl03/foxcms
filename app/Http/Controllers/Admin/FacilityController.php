<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = \App\Models\HotelFacility::orderBy('created_at', 'desc')->get();
        return view('admin.facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.facilities.create');
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
            'description_en' => 'nullable|string',
            'is_active' => 'boolean',
            'show_description' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['show_description'] = $request->has('show_description');

        \App\Models\HotelFacility::create($validated);

        return redirect()->route('admin.facilities.index')->with('success', 'Facility created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $facility = \App\Models\HotelFacility::findOrFail($id);
        return view('admin.facilities.edit', compact('facility'));
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
            'description_en' => 'nullable|string',
            'is_active' => 'boolean',
            'show_description' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['show_description'] = $request->has('show_description');

        $facility = \App\Models\HotelFacility::findOrFail($id);
        $facility->update($validated);

        return redirect()->route('admin.facilities.index')->with('success', 'Facility updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $facility = \App\Models\HotelFacility::findOrFail($id);
        $facility->delete();

        return redirect()->route('admin.facilities.index')->with('success', 'Facility deleted successfully.');
    }
}
