<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeMenuController extends Controller
{
    public function index()
    {
        $menus = HomeMenu::orderBy('sort_order')->get();
        return view('admin.home-menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.home-menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_key' => 'required|unique:home_menus',
            'menu_name' => 'required',
            'action_type' => 'required',
            'icon' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('icon');
        
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('menu_icons', 'public');
            $data['icon_path'] = 'storage/' . $path;
        }

        HomeMenu::create($data);

        return redirect()->route('admin.home-menus.index')->with('success', 'Menu created successfully');
    }

    public function edit($id)
    {
        $menu = HomeMenu::findOrFail($id);
        return view('admin.home-menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = HomeMenu::findOrFail($id);
        
        $request->validate([
            'menu_key' => 'required|unique:home_menus,menu_key,' . $id,
            'menu_name' => 'required',
            'action_type' => 'required',
            'icon' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('icon');
        
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($menu->icon_path && str_starts_with($menu->icon_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $menu->icon_path));
            }
            
            $path = $request->file('icon')->store('menu_icons', 'public');
            $data['icon_path'] = 'storage/' . $path;
        }

        $menu->update($data);

        return redirect()->route('admin.home-menus.index')->with('success', 'Menu updated successfully');
    }

    public function destroy($id)
    {
        $menu = HomeMenu::findOrFail($id);
        
        if ($menu->icon_path && str_starts_with($menu->icon_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $menu->icon_path));
        }
        
        $menu->delete();

        return redirect()->route('admin.home-menus.index')->with('success', 'Menu deleted successfully');
    }
}
