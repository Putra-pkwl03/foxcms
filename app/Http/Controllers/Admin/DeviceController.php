<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = \App\Models\ManagedDevice::orderBy('created_at', 'desc')->get();
        return view('admin.devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.devices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|max:100|unique:managed_devices',
            'device_name' => 'required|string|max:100',
            'room_number' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        \App\Models\ManagedDevice::create($validated);

        return redirect()->route('admin.devices.index')->with('success', 'Device registered successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $device = \App\Models\ManagedDevice::findOrFail($id);
        return view('admin.devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|max:100|unique:managed_devices,device_id,' . $id,
            'device_name' => 'required|string|max:100',
            'room_number' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $device = \App\Models\ManagedDevice::findOrFail($id);
        $device->update($validated);

        return redirect()->route('admin.devices.index')->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $device = \App\Models\ManagedDevice::findOrFail($id);
        $device->delete();

        return redirect()->route('admin.devices.index')->with('success', 'Device deleted successfully.');
    }
}
