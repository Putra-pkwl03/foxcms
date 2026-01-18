<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'dining' => \App\Models\DiningMenu::count(),
            'facilities' => \App\Models\HotelFacility::count(),
            'apps' => \App\Models\SystemApp::count(),
            'devices' => \App\Models\ManagedDevice::count(),
            'guests' => \App\Models\GuestCheckin::where('status', 'checked_in')->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
