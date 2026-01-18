@extends('layouts.admin')

@section('page-title', 'Register Device')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Register New Device</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.devices.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <x-larastrap::text name="device_id" label="Device ID (Unique Code)" placeholder="e.g. TV-QMEK3X" required />
                        <small class="text-muted">Enter the unique code displayed on the TV screen.</small>
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="device_name" label="Device Name" placeholder="e.g. LG Smart TV" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="room_number" label="Room Number" placeholder="e.g. 101" required />
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Active (Device can access launcher)</label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.devices.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Register Device</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
