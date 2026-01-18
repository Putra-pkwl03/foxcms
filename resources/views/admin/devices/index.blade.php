@extends('layouts.admin')

@section('page-title', 'Managed Devices')

@section('content')
<div class="row mb-3">
    <div class="col-12 text-end">
        <a href="{{ route('admin.devices.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Register Device
        </a>
    </div>
</div>

<div class="card premium-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Registered Devices</h5>
        <a href="{{ route('admin.devices.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Register Device
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Device ID</th>
                        <th>Name</th>
                        <th>Room</th>
                        <th>Status</th>
                        <th>Last Seen</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devices as $device)
                    <tr>
                        <td class="ps-4"><code class="text-primary fw-bold">{{ $device->device_id }}</code></td>
                        <td>
                            <div class="fw-bold text-dark">{{ $device->device_name }}</div>
                            <small class="text-muted">ID: #{{ $device->id }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $device->room_number }}</span></td>
                        <td>
                            @if($device->is_active)
                                <span class="badge bg-success-subtle text-success px-3 rounded-pill">Active</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 rounded-pill">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock-history me-2 text-muted"></i>
                                {{ $device->last_seen ? $device->last_seen->diffForHumans() : 'Never' }}
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('admin.devices.edit', $device->id) }}" class="btn btn-sm btn-white">
                                    <i class="bi bi-pencil-square text-primary"></i>
                                </a>
                                <form action="{{ route('admin.devices.destroy', $device->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-white">
                                        <i class="bi bi-trash3-fill text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-display fs-1 d-block mb-3 opacity-25"></i>
                            No devices found in the database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
