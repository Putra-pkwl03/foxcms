<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemAppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apps = \App\Models\SystemApp::orderBy('sort_order', 'asc')->get();
        return view('admin.system-apps.index', compact('apps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.system-apps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'app_key'         => 'required|string|max:50|unique:system_apps',
            'app_name'        => 'required|string|max:100',
            'app_name_en'     => 'nullable|string|max:100',
            'icon_path'       => 'required|string',
            'sort_order'      => 'integer',
            'android_package' => 'nullable|string',
            'apk_url'         => 'nullable|string', 
            'is_visible'      => 'nullable',      
        ]);

        // Logika konversi ke 1 atau 0
        $validated['is_visible'] = $request->has('is_visible') ? 1 : 0;

        \App\Models\SystemApp::create($validated);

        return redirect()->route('admin.system-apps.index')->with('success', 'App configuration created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $app = \App\Models\SystemApp::findOrFail($id);
        return view('admin.system-apps.edit', compact('app'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'app_key'         => 'required|string|max:50|unique:system_apps,app_key,' . $id,
            'app_name'        => 'required|string|max:100',
            'app_name_en'     => 'nullable|string|max:100',
            'icon_path'       => 'required|string',
            'sort_order'      => 'integer',
            'android_package' => 'nullable|string',
            'apk_url'         => 'nullable|string', 
            'is_visible'      => 'nullable',       
        ]);

        // Logika konversi ke 1 atau 0
        $validated['is_visible'] = $request->has('is_visible') ? 1 : 0;

        $app = \App\Models\SystemApp::findOrFail($id);
        $app->update($validated);

        return redirect()->route('admin.system-apps.index')->with('success', 'App configuration updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $app = \App\Models\SystemApp::findOrFail($id);
        $app->delete();

        return redirect()->route('admin.system-apps.index')->with('success', 'App configuration deleted successfully.');
    }
}
