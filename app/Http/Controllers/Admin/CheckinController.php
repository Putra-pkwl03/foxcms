<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function index()
    {
        $checkins = \App\Models\GuestCheckin::orderBy('created_at', 'desc')->get();
        return view('admin.checkin.index', compact('checkins'));
    }

    public function create()
    {
        return view('admin.checkin.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10',
            'guest_name' => 'required|string|max:100',
            'checkin_time' => 'required|date',
            'checkout_time' => 'nullable|date',
            'status' => 'required|in:checked_in,checked_out',
        ]);

        \App\Models\GuestCheckin::create($validated);

        return redirect()->route('admin.checkin.index')->with('success', 'Guest checked in successfully.');
    }

    public function edit(string $id)
    {
        $checkin = \App\Models\GuestCheckin::findOrFail($id);
        return view('admin.checkin.edit', compact('checkin'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10',
            'guest_name' => 'required|string|max:100',
            'checkin_time' => 'required|date',
            'checkout_time' => 'nullable|date',
            'status' => 'required|in:checked_in,checked_out',
        ]);

        $checkin = \App\Models\GuestCheckin::findOrFail($id);
        $checkin->update($validated);

        return redirect()->route('admin.checkin.index')->with('success', 'Check-in details updated.');
    }

    public function destroy(string $id)
    {
        $checkin = \App\Models\GuestCheckin::findOrFail($id);
        $checkin->delete();

        return redirect()->route('admin.checkin.index')->with('success', 'Record deleted.');
    }
}
