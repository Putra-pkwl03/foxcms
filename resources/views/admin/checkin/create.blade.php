@extends('layouts.admin')

@section('page-title', 'New Check-In')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Register Guest Check-In</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.checkin.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <x-larastrap::text name="room_number" label="Room Number" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="guest_name" label="Guest Name" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::datetime name="checkin_time" label="Check-In Time" :value="now()->format('Y-m-d\TH:i')" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::datetime name="checkout_time" label="Check-Out Time (Optional)" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="checked_in">Checked In</option>
                            <option value="checked_out">Checked Out</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.checkin.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Check-In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
