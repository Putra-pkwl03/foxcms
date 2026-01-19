@extends('layouts.admin')

@section('page-title', 'Amenity Requests')

@section('content')

<div class="mb-4">
    <h5 class="mb-3 text-primary fw-bold"><i class="bi bi-bell me-2"></i>Active Amenities Requests (Pending)</h5>
    
    @forelse($activeRequests as $room => $requests)
        @php
            $firstReq = $requests->first();
            $guestName = $firstReq->guest_name ?? 'Unknown';
            $requestCount = $requests->count();
            // Calculate total items roughly by counting requests? 
            // Since quantity is inside 'items' string, request count is best proxy here.
        @endphp
        <div class="card premium-card mb-3 border-warning" style="border-left: 5px solid;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                 <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">Room {{ $room }} <span class="text-muted fs-6">({{ $guestName }})</span></h5>
                        <small class="text-muted">{{ $requestCount }} Request(s)</small>
                    </div>
                 
                </div>
                 <div class="text-end">
                    <small class="text-secondary fw-bold text-uppercase">Last Request</small>
                    <div class="fw-bold">{{ $requests->max('created_at')->diffForHumans() }}</div>
                </div>
            </div>
            <div class="card-body bg-light-subtle">
                 <div class="row align-items-center">
                    <div class="col-md-9">
                        <small class="text-secondary text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Items Requested</small>
                        <p class="mb-0 mt-1 fw-medium text-dark">
                             @foreach($requests->take(5) as $req)
                                <span class="me-3"><i class="bi bi-dot"></i> {{ $req->items }}</span>
                             @endforeach
                              @if($requests->count() > 5)
                                <span class="text-muted fst-italic">+ {{ $requests->count() - 5 }} more...</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-3 text-end d-none d-md-block">
                        <a href="{{ route('admin.requests.amenities.room', $room) }}" class="btn btn-outline-primary stretched-link">
                            View Full Details <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                 </div>
            </div>
        </div>
    @empty
        <div class="alert alert-light border shadow-sm text-center py-4">
            <i class="bi bi-check-circle text-muted fs-1 d-block mb-2"></i>
            No active amenity requests.
        </div>
    @endforelse
</div>
@endsection
