<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function dining()
    {
        // Active orders: Pending or Confirmed
        $activeOrders = \App\Models\HotelOrder::whereIn('status', ['Pending', 'Confirmed'])
            ->orderBy('created_at', 'asc') // Oldest first for active
            ->get()
            ->groupBy('room_number'); // Group by room

        // History: Delivered or Cancelled
        $historyOrders = \App\Models\HotelOrder::whereIn('status', ['Delivered', 'Cancelled'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.requests.dining', compact('activeOrders', 'historyOrders'));
    }

    public function diningRoomDetail($room)
    {
        $orders = \App\Models\HotelOrder::where('room_number', $room)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('admin.requests.dining-room', compact('orders', 'room'));
    }

    public function amenities()
    {
        $activeRequests = \App\Models\AmenityRequest::where('status', 'Pending')
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('room_number');

        return view('admin.requests.amenities', compact('activeRequests'));
    }

    public function amenityRoomDetail($room)
    {
         $requests = \App\Models\AmenityRequest::where('room_number', $room)
            ->where('status', 'Pending')
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('admin.requests.amenities-room', compact('requests', 'room'));
    }

    public function updateDiningStatus(\Illuminate\Http\Request $request, $id)
    {
        $order = \App\Models\HotelOrder::findOrFail($id);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Order status updated.');
    }

    public function updateAmenityStatus(\Illuminate\Http\Request $request, $id)
    {
        $req = \App\Models\AmenityRequest::findOrFail($id);
        $req->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Request status updated.');
    }
}
