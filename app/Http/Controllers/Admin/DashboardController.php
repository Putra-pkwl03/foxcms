<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistics
        $stats = [
            'dining' => \App\Models\DiningMenu::count(),
            'facilities' => \App\Models\HotelFacility::count(),
            'apps' => \App\Models\SystemApp::count(),
            'devices' => \App\Models\ManagedDevice::count(),
            'guests' => \App\Models\GuestCheckin::where('status', 'checked_in')->count(),
            // Additional stats for charts
            'amenities_count' => \App\Models\RoomAmenity::count() ?? 0,
            'info_count' => \App\Models\HotelInfo::count() ?? 0,
            // Request stats for charts
            'orders_today' => \App\Models\HotelOrder::whereDate('created_at', today())->count(),
            'requests_today' => \App\Models\AmenityRequest::whereDate('created_at', today())->count(),
            'checkins_today' => \App\Models\GuestCheckin::whereDate('created_at', today())->count(),
        ];

        // 2. Recent Activities (Unified Stream)
        $activities = collect();

        // - Check-ins
        $checkins = \App\Models\GuestCheckin::latest()->take(5)->get()->map(function($item) {
            return [
                'type' => 'checkin',
                'title' => 'New Guest Check-In',
                'description' => "Guest {$item->guest_name} checked in to Room {$item->room_number}",
                'time' => $item->created_at,
                'icon' => 'bi-person-check',
                'color' => 'primary'
            ];
        });
        $activities = $activities->merge($checkins);

        // - Dining Orders
        $orders = \App\Models\HotelOrder::latest()->take(5)->get()->map(function($item) {
            $items = json_decode($item->items, true);
            $count = is_array($items) ? count($items) : 0;
            return [
                'type' => 'dining',
                'title' => 'Dining Order Received',
                'description' => "Order #{$item->id} from Room {$item->room_number} ({$count} items)",
                'time' => $item->created_at,
                'icon' => 'bi-bag-check',
                'color' => 'success'
            ];
        });
        $activities = $activities->merge($orders);

        // - Amenity Requests
        $requests = \App\Models\AmenityRequest::latest()->take(5)->get()->map(function($item) {
            return [
                'type' => 'amenity',
                'title' => 'Amenity Request',
                'description' => "Room {$item->room_number} requested items",
                'time' => $item->created_at,
                'icon' => 'bi-hand-thumbs-up',
                'color' => 'warning'
            ];
        });
        $activities = $activities->merge($requests);
        
        // Sort by time desc and take top 10
        $recent_activities = $activities->sortByDesc('time')->take(8);

        // 3. Chart Data (Mocking specific day data for simplicity, usually needs group by date query)
        // For now, we'll keep the chart line data static or basic random, but the doughnut chart can be real.

        return view('admin.dashboard', compact('stats', 'recent_activities'));
    }
}
