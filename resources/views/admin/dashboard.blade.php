@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="premium-card h-100 border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Dining Items</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $stats['dining'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-egg-fried fs-1 text-gray-300 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="premium-card h-100 border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hotel Facilities</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $stats['facilities'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-building fs-1 text-gray-300 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="premium-card h-100 border-start border-info border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Devices</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $stats['devices'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-display fs-1 text-gray-300 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="premium-card h-100 border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Current Guests</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $stats['guests'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people-fill fs-1 text-gray-300 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Latest Activity</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Welcome to the new AHF Admin Panel. This system is migrated from the legacy PHP application.</p>
            </div>
        </div>
    </div>
</div>
@endsection
