@extends('layouts.admin')

@section('page-title', 'Dining Detail: Room ' . $room)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.requests.dining') }}" class="btn btn-outline-secondary bg-white">
        <i class="bi bi-arrow-left me-2"></i>Back to Orders
    </a>
    <h4 class="fw-bold m-0 text-white">Room {{ $room }} Detail</h4>
    <!-- Placeholder for bulk actions -->
</div>

<div class="card premium-card border-0 shadow">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div>
            @php
                $firstOrder = $orders->first();
                $guestName = $firstOrder->guest_name ?? 'Unknown';
            @endphp
            <h5 class="mb-0 fw-bold text-dark">Guest: {{ $guestName }}</h5>
            <span class="badge bg-primary rounded-pill">{{ $orders->count() }} Items</span>
        </div>
        <div class="text-end">
            <small class="text-muted d-block uppercase fw-bold" style="letter-spacing:1px;">Total Bill</small>
            <h3 class="mb-0 fw-bold text-success">Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Item Ordered</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Time</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $order->items }}</td>
                        <td class="text-muted text-italic"><small>{{ $order->notes ?? '-' }}</small></td>
                        <td>
                            <span class="badge bg-{{ $order->status == 'Pending' ? 'warning' : 'info' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('H:i') }}</td>
                        <td class="text-end pe-4 text-nowrap">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="#" class="btn btn-sm btn-success d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('status-form-{{ $order->id }}-confirmed').submit();">
                                    <i class="bi bi-check-circle me-1"></i> Confirm
                                </a>
                                <a href="#" class="btn btn-sm btn-primary d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('status-form-{{ $order->id }}-delivered').submit();">
                                    <i class="bi bi-box-seam me-1"></i> Deliver
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('status-form-{{ $order->id }}-cancelled').submit();">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </div>
                            
                            <form id="status-form-{{ $order->id }}-confirmed" action="{{ route('admin.requests.dining.update', $order->id) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="status" value="Confirmed">
                            </form>
                            <form id="status-form-{{ $order->id }}-delivered" action="{{ route('admin.requests.dining.update', $order->id) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="status" value="Delivered">
                            </form>
                            <form id="status-form-{{ $order->id }}-cancelled" action="{{ route('admin.requests.dining.update', $order->id) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="status" value="Cancelled">
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-check-all fs-1 d-block mb-3"></i>
                            All orders for this room have been processed.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
