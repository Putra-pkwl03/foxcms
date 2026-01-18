@extends('layouts.admin')

@section('page-title', 'Guest Check-In')

@section('content')
<div class="row mb-3">
    <div class="col-12 text-end">
        <a href="{{ route('admin.checkin.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> New Check-In
        </a>
    </div>
</div>

<div class="card premium-card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">Active Guest Check-Ins</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Room</th>
                        <th>Guest Name</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($checkins as $checkin)
                    <tr>
                        <td><span class="fw-bold">{{ $checkin->room_number }}</span></td>
                        <td>{{ $checkin->guest_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($checkin->checkin_time)->format('d M Y, H:i') }}</td>
                        <td>{{ $checkin->checkout_time ? \Carbon\Carbon::parse($checkin->checkout_time)->format('d M Y, H:i') : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $checkin->status === 'checked_in' ? 'success' : 'secondary' }}">
                                {{ Str::headline($checkin->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.checkin.edit', $checkin->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.checkin.destroy', $checkin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No check-in records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
