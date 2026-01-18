<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index()
    {
        $infos = \App\Models\HotelInfo::orderBy('sort_order', 'asc')->get();
        return view('admin.info.index', compact('infos'));
    }

    public function create()
    {
        return view('admin.info.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'title_en' => 'nullable|string|max:150',
            'description' => 'required|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'integer',
            'show_description' => 'boolean',
        ]);

        $validated['show_description'] = $request->has('show_description');

        \App\Models\HotelInfo::create($validated);

        return redirect()->route('admin.info.index')->with('success', 'Information page created.');
    }

    public function edit(string $id)
    {
        $info = \App\Models\HotelInfo::findOrFail($id);
        return view('admin.info.edit', compact('info'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'title_en' => 'nullable|string|max:150',
            'description' => 'required|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'integer',
            'show_description' => 'boolean',
        ]);

        $validated['show_description'] = $request->has('show_description');

        $info = \App\Models\HotelInfo::findOrFail($id);
        $info->update($validated);

        return redirect()->route('admin.info.index')->with('success', 'Information page updated.');
    }

    public function destroy(string $id)
    {
        $info = \App\Models\HotelInfo::findOrFail($id);
        $info->delete();

        return redirect()->route('admin.info.index')->with('success', 'Information page deleted.');
    }
}
