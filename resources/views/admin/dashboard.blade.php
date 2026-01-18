@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<style>
    /* Gradient Stat Cards */
    .stat-card {
        position: relative;
        background: white;
        border-radius: 1.25rem;
        padding: 1.75rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        opacity: 0.05;
        transition: opacity 0.4s ease;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .stat-card:hover::before {
        opacity: 0.1;
    }

    .stat-card.primary {
        --gradient-start: #667eea;
        --gradient-end: #764ba2;
    }

    .stat-card.success {
        --gradient-start: #11998e;
        --gradient-end: #38ef7d;
    }

    .stat-card.info {
        --gradient-start: #4facfe;
        --gradient-end: #00f2fe;
    }

    .stat-card.warning {
        --gradient-start: #f093fb;
        --gradient-end: #f5576c;
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        color: white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.5rem;
    }

    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        margin-top: 0.75rem;
    }

    .stat-trend.up {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }

    .stat-trend.down {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    /* Welcome Hero */
    .welcome-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1.5rem;
        padding: 2.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .welcome-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: pulse 4s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.3; }
    }

    .welcome-hero h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .welcome-hero p {
        font-size: 1.125rem;
        opacity: 0.95;
        position: relative;
        z-index: 1;
        margin: 0;
    }

    /* Activity Card */
    .activity-item {
        padding: 1.25rem;
        border-left: 3px solid #e2e8f0;
        margin-bottom: 1rem;
        border-radius: 0.75rem;
        background: #f8fafc;
        transition: all 0.3s ease;
        position: relative;
    }

    .activity-item:hover {
        background: white;
        border-left-color: #667eea;
        transform: translateX(8px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .activity-item::before {
        content: '';
        position: absolute;
        left: -9px;
        top: 50%;
        transform: translateY(-50%);
        width: 12px;
        height: 12px;
        background: white;
        border: 3px solid #667eea;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .activity-item:hover::before {
        opacity: 1;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        margin-right: 1rem;
    }

    /* Quick Actions */
    .quick-action {
        background: white;
        border: 2px solid #f1f5f9;
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: block;
        color: inherit;
    }

    .quick-action:hover {
        border-color: #667eea;
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.2);
        color: inherit;
    }

    .quick-action-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        color: white;
    }

    .quick-action-label {
        font-weight: 600;
        color: #334155;
        margin: 0;
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 300px;
        padding: 1rem;
    }
</style>

<!-- Welcome Hero -->
<div class="welcome-hero">
    <h2><i class="bi bi-stars me-2"></i>Welcome back, Administrator!</h2>
    <p>Here's what's happening with your hotel management system today.</p>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card primary">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <div class="stat-value">{{ $stats['dining'] }}</div>
                    <div class="stat-label">Dining Items</div>
                    <div class="stat-trend up">
                        <i class="bi bi-arrow-up"></i>
                        <span>12% from last month</span>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-egg-fried"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card success">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <div class="stat-value">{{ $stats['facilities'] }}</div>
                    <div class="stat-label">Hotel Facilities</div>
                    <div class="stat-trend up">
                        <i class="bi bi-arrow-up"></i>
                        <span>8% from last month</span>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card info">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <div class="stat-value">{{ $stats['devices'] }}</div>
                    <div class="stat-label">Total Devices</div>
                    <div class="stat-trend up">
                        <i class="bi bi-arrow-up"></i>
                        <span>5% from last month</span>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-display"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card warning">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <div class="stat-value">{{ $stats['guests'] }}</div>
                    <div class="stat-label">Current Guests</div>
                    <div class="stat-trend down">
                        <i class="bi bi-arrow-down"></i>
                        <span>3% from yesterday</span>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Activity -->
<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="premium-card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-lightning-charge-fill me-2 text-warning"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('admin.devices.index') }}" class="quick-action" style="--gradient-start: #667eea; --gradient-end: #764ba2;">
                            <div class="quick-action-icon">
                                <i class="bi bi-display"></i>
                            </div>
                            <p class="quick-action-label">Manage Devices</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.checkin.index') }}" class="quick-action" style="--gradient-start: #11998e; --gradient-end: #38ef7d;">
                            <div class="quick-action-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <p class="quick-action-label">Check-In</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.dining-menu.index') }}" class="quick-action" style="--gradient-start: #f093fb; --gradient-end: #f5576c;">
                            <div class="quick-action-icon">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                            <p class="quick-action-label">Dining Menu</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.facilities.index') }}" class="quick-action" style="--gradient-start: #4facfe; --gradient-end: #00f2fe;">
                            <div class="quick-action-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <p class="quick-action-label">Facilities</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-lg-8">
        <div class="premium-card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="activity-item">
                    <div class="d-flex align-items-start">
                        <div class="activity-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">New Guest Check-In</h6>
                            <p class="text-muted mb-1 small">Guest #{{ $stats['guests'] }} has checked in to Room 305</p>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i>2 minutes ago</small>
                        </div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="d-flex align-items-start">
                        <div class="activity-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-bag-check"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Dining Order Completed</h6>
                            <p class="text-muted mb-1 small">Order #1234 delivered to Room 201</p>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i>15 minutes ago</small>
                        </div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="d-flex align-items-start">
                        <div class="activity-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-display"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Device Status Update</h6>
                            <p class="text-muted mb-1 small">Device "Lobby-TV-01" is now online</p>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i>1 hour ago</small>
                        </div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="d-flex align-items-start">
                        <div class="activity-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-hand-thumbs-up"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Amenity Request</h6>
                            <p class="text-muted mb-1 small">Room 405 requested extra towels</p>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i>2 hours ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mt-2">
    <div class="col-lg-8">
        <div class="premium-card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-bar-chart-fill me-2 text-success"></i>Guest Activity Overview</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="premium-card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-pie-chart-fill me-2 text-info"></i>Service Distribution</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="serviceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Activity Chart
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    new Chart(activityCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Check-Ins',
                data: [12, 19, 15, 25, 22, 30, 28],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Orders',
                data: [8, 12, 10, 18, 15, 22, 20],
                borderColor: '#11998e',
                backgroundColor: 'rgba(17, 153, 142, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Service Chart
    const serviceCtx = document.getElementById('serviceChart').getContext('2d');
    new Chart(serviceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Dining', 'Amenities', 'Facilities', 'Info'],
            datasets: [{
                data: [{{ $stats['dining'] }}, 15, {{ $stats['facilities'] }}, 8],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(17, 153, 142, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(240, 147, 251, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endsection
