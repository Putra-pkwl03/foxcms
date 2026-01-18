@extends('layouts.admin')

@section('page-title', 'Amenity Requests')

@section('content')
<div class="card premium-card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">Active Amenity Requests</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Room</th>
                        <th>Guest</th>
                        <th>Requested Items</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr>
                        <td><code>#{{ $request->id }}</code></td>
                        <td><span class="fw-bold">{{ $request->room_number }}</span></td>
                        <td>{{ $request->guest_name }}</td>
                        <td>{{ $request->items }}</td>
                        <td>
                            @php
                                $colors = [
                                    'Pending' => 'warning',
                                    'Delivered' => 'success',
                                    'Cancelled' => 'danger'
                                ];
                            @endphp
                            <span class="badge bg-{{ $colors[$request->status] ?? 'secondary' }}">
                                {{ $request->status }}
                            </span>
                        </td>
                        <td>{{ $request->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <form action="{{ route('requests.amenities.update', $request->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Delivered">
                                    <button type="submit" class="btn btn-outline-success" {{ $request->status === 'Delivered' ? 'disabled' : '' }}>
                                        Confirm Delivery
                                    </button>
                                </form>
                                <form action="{{ route('requests.amenities.update', $request->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Cancelled">
                                    <button type="submit" class="btn btn-outline-danger" {{ $request->status === 'Cancelled' ? 'disabled' : '' }}>
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No amenity requests yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
