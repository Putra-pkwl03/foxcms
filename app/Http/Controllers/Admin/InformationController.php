<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'title' => 'required|string|max:150',
            'title_en' => 'nullable|string|max:150',
            'description' => 'required|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'integer',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['title', 'title_en', 'description', 'description_en', 'sort_order']);
        $data['show_description'] = $request->has('show_description');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'info_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/info'), $filename);
            $data['icon_path'] = 'uploads/info/' . $filename;
        }

        \App\Models\HotelInfo::create($data);

        return redirect()->route('admin.info.index')->with('success', 'Information page created.');
    }

    public function edit(string $id)
    {
        $info = \App\Models\HotelInfo::findOrFail($id);
        return view('admin.info.edit', compact('info'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'title_en' => 'nullable|string|max:150',
            'description' => 'required|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'integer',
            'image' => 'nullable|image|max:5120',
        ]);

        $info = \App\Models\HotelInfo::findOrFail($id);
        
        $data = $request->only(['title', 'title_en', 'description', 'description_en', 'sort_order']);
        $data['show_description'] = $request->has('show_description');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($info->icon_path && file_exists(public_path($info->icon_path))) {
                @unlink(public_path($info->icon_path));
            }
            
            $file = $request->file('image');
            $filename = 'info_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/info'), $filename);
            $data['icon_path'] = 'uploads/info/' . $filename;
        }

        $info->update($data);

        return redirect()->route('admin.info.index')->with('success', 'Information page updated.');
    }

    public function destroy(string $id)
    {
        $info = \App\Models\HotelInfo::findOrFail($id);
        
        // Delete image if exists
        if ($info->icon_path && file_exists(public_path($info->icon_path))) {
            @unlink(public_path($info->icon_path));
        }

        $info->delete();

        return redirect()->route('admin.info.index')->with('success', 'Information page deleted.');
    }
}
