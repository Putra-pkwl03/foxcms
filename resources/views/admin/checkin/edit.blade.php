@extends('layouts.admin')

@section('page-title', 'Edit Check-In')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Update Registration Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.checkin.update', $checkin->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <x-larastrap::text name="room_number" label="Room Number" :value="$checkin->room_number" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="guest_name" label="Guest Name" :value="$checkin->guest_name" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::datetime name="checkin_time" label="Check-In Time" :value="\Carbon\Carbon::parse($checkin->checkin_time)->format('Y-m-d\TH:i')" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::datetime name="checkout_time" label="Check-Out Time" :value="$checkin->checkout_time ? \Carbon\Carbon::parse($checkin->checkout_time)->format('Y-m-d\TH:i') : ''" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="checked_in" {{ $checkin->status === 'checked_in' ? 'selected' : '' }}>Checked In</option>
                            <option value="checked_out" {{ $checkin->status === 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.checkin.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
