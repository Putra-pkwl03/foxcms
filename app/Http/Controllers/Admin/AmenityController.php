<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = \App\Models\RoomAmenity::orderBy('created_at', 'desc')->get();
        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'name_en' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category' => 'required|string',
        ]);

        \App\Models\RoomAmenity::create($validated);

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity item created.');
    }

    public function edit(string $id)
    {
        $amenity = \App\Models\RoomAmenity::findOrFail($id);
        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'name_en' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category' => 'required|string',
        ]);

        $amenity = \App\Models\RoomAmenity::findOrFail($id);
        $amenity->update($validated);

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity item updated.');
    }

    public function destroy(string $id)
    {
        $amenity = \App\Models\RoomAmenity::findOrFail($id);
        $amenity->delete();

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity item deleted.');
    }
}
