@extends('layouts.admin')

@section('page-title', 'Amenities Detail: Room ' . $room)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.requests.amenities') }}" class="btn btn-outline-secondary bg-white">
        <i class="bi bi-arrow-left me-2"></i>Back to Requests
    </a>
    <h4 class="fw-bold m-0 text-white">Room {{ $room }} Request Details</h4>
    <!-- Bulk Actions Placeholder -->
</div>

<div class="card premium-card border-0 shadow">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div>
            @php
                $firstReq = $requests->first();
                $guestName = $firstReq->guest_name ?? 'Unknown';
            @endphp
            <h5 class="mb-0 fw-bold text-dark">Guest: {{ $guestName }}</h5>
            <span class="badge bg-primary rounded-pill">{{ $requests->count() }} Requests</span>
        </div>
        <div class="text-end">
            <!-- No total price for amenities -->
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Requested Item</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $req->items }}</td>
                        <td>
                            @php
                                $colors = [
                                    'Pending' => 'warning',
                                    'Delivered' => 'success',
                                    'Cancelled' => 'danger'
                                ];
                            @endphp
                            <span class="badge bg-{{ $colors[$req->status] ?? 'secondary' }}">
                                {{ $req->status }}
                            </span>
                        </td>
                        <td>{{ $req->created_at->format('H:i') }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="#" class="btn btn-sm btn-success d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('status-form-{{ $req->id }}-delivered').submit();">
                                    <i class="bi bi-check-circle me-1"></i> Deliver
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('status-form-{{ $req->id }}-cancelled').submit();">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </div>
                            
                            <form id="status-form-{{ $req->id }}-delivered" action="{{ route('admin.requests.amenities.update', $req->id) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="status" value="Delivered">
                            </form>
                            <form id="status-form-{{ $req->id }}-cancelled" action="{{ route('admin.requests.amenities.update', $req->id) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="status" value="Cancelled">
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-check-all fs-1 d-block mb-3"></i>
                            All requests for this room have been processed.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
