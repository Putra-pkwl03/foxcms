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
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('amenities', 'public');
            $validated['icon_path'] = 'storage/' . $path;
        }

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
            'image' => 'nullable|image|max:2048',
        ]);

        $amenity = \App\Models\RoomAmenity::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($amenity->icon_path && file_exists(public_path($amenity->icon_path))) {
                @unlink(public_path($amenity->icon_path));
            }

            $path = $request->file('image')->store('amenities', 'public');
            $validated['icon_path'] = 'storage/' . $path;
        }

        $amenity->update($validated);

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity item updated.');
    }

    public function destroy(string $id)
    {
        $amenity = \App\Models\RoomAmenity::findOrFail($id);
        
        if ($amenity->icon_path && file_exists(public_path($amenity->icon_path))) {
            @unlink(public_path($amenity->icon_path));
        }
        
        $amenity->delete();

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity item deleted.');
    }
}
