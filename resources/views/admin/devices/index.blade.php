@extends('layouts.admin')

@section('page-title', 'Managed Devices')

@section('content')


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
                        <th class="ps-4">Reg Code</th>
                        <th>Device info</th>
                        <th>Room</th>
                        <th>Connection</th>
                        <th>Active</th>
                        <th>Last Seen</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devices as $device)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle fw-mono">{{ $device->registration_code }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $device->device_name }}</div>
                            <small class="text-muted">ID: <code class="text-xs">{{ $device->device_id }}</code></small>
                            @if($device->ip_address)
                                <div class="small text-muted"><i class="bi bi-link-45deg"></i> {{ $device->ip_address }}</div>
                            @endif
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $device->room_number }}</span></td>
                        <td>
                            @if($device->status_online == 'online')
                                <span class="badge bg-success border border-success px-2 rounded-pill"><i class="bi bi-circle-fill me-1 small"></i> Online</span>
                            @else
                                <span class="badge bg-secondary border px-2 rounded-pill">Offline</span>
                            @endif
                        </td>
                        <td>
                            @if($device->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 rounded-pill">True</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 rounded-pill">False</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center small">
                                <i class="bi bi-clock-history me-2 text-muted"></i>
                                {{ $device->last_seen ? $device->last_seen->diffForHumans() : 'Never' }}
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm border rounded">
                                <form action="{{ route('admin.devices.toggle-active', $device->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-white border-end px-3 py-2" title="{{ $device->is_active ? 'Deactivate' : 'Activate' }}">
                                        @if($device->is_active)
                                            <i class="bi bi-x-circle fs-5 text-warning"></i>
                                        @else
                                            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                                        @endif
                                    </button>
                                </form>
                                <a href="{{ route('admin.devices.tools', $device->id) }}" class="btn btn-white border-end px-3 py-2" title="Device Tools">
                                    <i class="bi bi-gear-fill fs-5 text-secondary"></i>
                                </a>
                                <a href="{{ route('admin.devices.edit', $device->id) }}" class="btn btn-white border-end px-3 py-2" title="Edit Device">
                                    <i class="bi bi-pencil-square fs-5 text-primary"></i>
                                </a>
                                <form action="{{ route('admin.devices.destroy', $device->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-white px-3 py-2" title="Delete Device">
                                        <i class="bi bi-trash3-fill fs-5 text-danger"></i>
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
