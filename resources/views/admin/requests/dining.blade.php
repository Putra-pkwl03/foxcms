@extends('layouts.admin')

@section('page-title', 'Dining Orders')

@section('content')
<div class="card premium-card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">Active Dining Orders</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Room</th>
                        <th>Guest</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><code>#{{ $order->id }}</code></td>
                        <td><span class="fw-bold">{{ $order->room_number }}</span></td>
                        <td>{{ $order->guest_name }}</td>
                        <td>
                            <small>{{ $order->items }}</small>
                        </td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $colors = [
                                    'Pending' => 'warning',
                                    'Confirmed' => 'info',
                                    'Delivered' => 'success',
                                    'Cancelled' => 'danger'
                                ];
                            @endphp
                            <span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Update
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('status-form-{{ $order->id }}-confirmed').submit();">Confirm</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('status-form-{{ $order->id }}-delivered').submit();">Deliver</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('status-form-{{ $order->id }}-cancelled').submit();">Cancel</a></li>
                                </ul>
                            </div>
                            
                            <form id="status-form-{{ $order->id }}-confirmed" action="{{ route('requests.dining.update', $order->id) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="status" value="Confirmed">
                            </form>
                            <form id="status-form-{{ $order->id }}-delivered" action="{{ route('requests.dining.update', $order->id) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="status" value="Delivered">
                            </form>
                            <form id="status-form-{{ $order->id }}-cancelled" action="{{ route('requests.dining.update', $order->id) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="status" value="Cancelled">
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No dining orders yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
