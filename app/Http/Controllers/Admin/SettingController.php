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

        \App\Models\SystemMarquee::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->content,
                'is_active' => $request->has('is_active'),
            ]
        );

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
        
        // Handle File Uploads
        $fileKeys = [
            'custom_greeting_image', 
            'launcher_home_bg', 
            'loading_logo_url', 
            'intro_video_url'
        ];

        foreach ($fileKeys as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $folder = 'uploads/settings';
                $filename = $key . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Ensure directory exists
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }

                // Delete old file if exists
                $oldSetting = \App\Models\GlobalSetting::where('setting_key', $key)->first();
                if ($oldSetting && $oldSetting->setting_value && file_exists(public_path($oldSetting->setting_value))) {
                    if (!str_contains($oldSetting->setting_value, 'assets/')) { // Don't delete local assets
                         @unlink(public_path($oldSetting->setting_value));
                    }
                }

                $file->move(public_path($folder), $filename);
                $data[$key] = $folder . '/' . $filename;
            }
        }

        // Special handling for Launcher APK
        if ($request->hasFile('launcher_apk_file')) {
            $file = $request->file('launcher_apk_file');
            $folder = 'uploads/update';
            $filename = 'launcher_update.apk'; // Fixed name for the API

            if (!file_exists(public_path($folder))) {
                mkdir(public_path($folder), 0755, true);
            }

            $file->move(public_path($folder), $filename);
            $data['launcher_apk_file'] = $filename;
        }

        foreach ($data as $key => $value) {
            // Only save if value is a string or numeric (not an UploadedFile object)
            if ($value !== null && !($value instanceof \Illuminate\Http\UploadedFile)) {
                \App\Models\GlobalSetting::updateOrCreate(
                    ['setting_key' => $key],
                    ['setting_value' => $value]
                );
            }
        }

        return redirect()->back()->with('success', 'Global settings updated successfully.');
    }
}
