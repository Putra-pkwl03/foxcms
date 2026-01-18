<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function marquee()
    {
        $marquee = \App\Models\SystemMarquee::first();
        return view('admin.settings.marquee', compact('marquee'));
    }

    public function updateMarquee(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $marquee = \App\Models\SystemMarquee::firstOrCreate(['id' => 1]);
        $marquee->update([
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Running text updated successfully.');
    }

    public function global()
    {
        $settings = \App\Models\GlobalSetting::all()->pluck('setting_value', 'setting_key');
        return view('admin.settings.global', compact('settings'));
    }

    public function updateGlobal(\Illuminate\Http\Request $request)
    {
        $data = $request->except('_token');
        
        foreach ($data as $key => $value) {
            \App\Models\GlobalSetting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Global settings updated successfully.');
    }
}
