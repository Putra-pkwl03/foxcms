<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function dining()
    {
        $orders = \App\Models\HotelOrder::orderBy('created_at', 'desc')->get();
        return view('admin.requests.dining', compact('orders'));
    }

    public function amenities()
    {
        $requests = \App\Models\AmenityRequest::orderBy('created_at', 'desc')->get();
        return view('admin.requests.amenities', compact('requests'));
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
