@extends('layouts.admin')

@section('page-title', 'Dining Orders')

@section('content')

<!-- Active Orders Section -->
<div class="mb-4">
    <h5 class="mb-3 text-primary fw-bold"><i class="bi bi-hourglass-split me-2"></i>Active Orders (Pending / Confirmed)</h5>
    
    @forelse($activeOrders as $room => $orders)
        @php
            $roomTotal = $orders->sum('total_price');
            $firstOrder = $orders->first();
            $guestName = $firstOrder->guest_name ?? 'Unknown';
            $bgClass = $orders->contains('status', 'Pending') ? 'border-warning' : 'border-info';
        @endphp
        <div class="card premium-card mb-3 {{ $bgClass }}" style="border-left: 5px solid;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">Room {{ $room }} <span class="text-muted fs-6">({{ $guestName }})</span></h5>
                        <small class="text-muted">{{ $orders->count() }} Items Ordered</small>
                    </div>
    
                </div>
                <div class="text-end">
                    <h4 class="mb-0 fw-bold text-success">Rp {{ number_format($roomTotal, 0, ',', '.') }}</h4>
                    <span class="badge bg-light text-dark border">Total Bill</span>
                </div>
            </div>
            <div class="card-body bg-light-subtle">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <small class="text-secondary text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Order Summary</small>
                        @php
                            $names = $orders->map(function($o) {
                                return $o->items; // Assumes 'items' is the string name like "Nasi Goreng (2)"
                            })->take(5);
                            $remaining = $orders->count() - 5;
                        @endphp
                        <p class="mb-2 mt-1 fw-medium text-dark">
                            @foreach($names as $name)
                                <i class="bi bi-dot"></i> {{ $name }} 
                            @endforeach
                            @if($remaining > 0)
                                <span class="text-muted fst-italic">+ {{ $remaining }} more items...</span>
                            @endif
                        </p>
                        <div>
                            @foreach($orders->pluck('status')->unique() as $status)
                                <span class="badge bg-{{ $status == 'Pending' ? 'warning' : 'info' }} border border-{{ $status == 'Pending' ? 'warning' : 'info' }} bg-opacity-10 text-{{ $status == 'Pending' ? 'dark' : 'dark' }}">
                                    {{ $status }}
                                </span>
                            @endforeach
                            <small class="text-muted ms-2"><i class="bi bi-clock me-1"></i>Last update: {{ $orders->max('updated_at')->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-end d-none d-md-block">
                        <a href="{{ route('admin.requests.dining.room', $room) }}" class="btn btn-outline-primary stretched-link">
                            View Full Details <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-light border shadow-sm text-center py-4">
            <i class="bi bi-check-circle text-muted fs-1 d-block mb-2"></i>
            No active orders at the moment.
        </div>
    @endforelse
</div>


@endsection
