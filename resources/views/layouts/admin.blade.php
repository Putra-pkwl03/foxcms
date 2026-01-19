<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AHF Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --bg-light: #f8f9fc;
            --sidebar-bg: #1a1c23;
            --card-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
            --header-height: 70px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-light);
            color: #4e5e80;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            background: var(--sidebar-bg);
            color: #94a3b8;
            padding: 0;
            position: fixed;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            background: rgba(255,255,255,0.02);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 0;
            font-size: 1.25rem;
        }

        .sidebar-content {
            padding: 1.5rem 0;
            height: calc(100vh - var(--header-height));
            overflow-y: auto;
        }

        .sidebar-heading {
            padding: 0.75rem 1.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #4b5563;
        }

        .sidebar a {
            color: #94a3b8;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            font-weight: 500;
        }

        .sidebar a i {
            font-size: 1.1rem;
            margin-right: 1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar a:hover {
            color: white;
            background: rgba(255,255,255,0.05);
        }

        .sidebar a.active {
            color: white;
            background: linear-gradient(90deg, rgba(67, 97, 238, 0.15) 0%, rgba(67, 97, 238, 0) 100%);
            border-left-color: var(--primary-color);
        }

        /* Main Content Styling */
        .main-wrapper {
            margin-left: 16.666667%; /* col-md-2 */
            width: 83.333333%;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .main-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }

        .top-navbar {
            height: var(--header-height);
            background: white;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-container {
            padding: 2rem;
        }

        /* Premium Components */
        .premium-card {
            background: white;
            border: 1px solid #f1f5f9;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            background: transparent !important;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-header h5 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons & Inputs */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.6rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(67, 97, 238, 0.25);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(67, 97, 238, 0.3);
        }

        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            color: #334155;
            background-color: #f8fafc;
        }

        .form-control:focus, .form-select:focus {
            background-color: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .btn-white {
            background-color: white;
            border: 1px solid #e2e8f0;
            color: #475569;
        }

        .btn-white:hover {
            background-color: #f8fafc;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .section-header i {
            width: 36px;
            height: 36px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .section-header h6 {
            margin: 0;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

<div class="sidebar d-none d-md-block col-md-3 col-lg-2">
    <div class="sidebar-brand">
        <h4>AHF ADMIN</h4>
    </div>
    <div class="sidebar-content">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="{{ route('admin.devices.index') }}" class="{{ request()->routeIs('admin.devices.*') ? 'active' : '' }}">
            <i class="bi bi-display-fill"></i> Devices
        </a>
        <a href="{{ route('admin.checkin.index') }}" class="{{ request()->routeIs('admin.checkin.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge-fill"></i> Check-In
        </a>
        <a href="{{ route('admin.info.index') }}" class="{{ request()->routeIs('admin.info.*') ? 'active' : '' }}">
            <i class="bi bi-info-circle-fill"></i> Info Pages
        </a>

        <div class="sidebar-heading mt-4">Master Data</div>
        <a href="{{ route('admin.dining-menu.index') }}" class="{{ request()->routeIs('admin.dining-menu.*') ? 'active' : '' }}">
            <i class="bi bi-cup-hot-fill"></i> Dining Menu
        </a>
        <a href="{{ route('admin.facilities.index') }}" class="{{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">
            <i class="bi bi-building-fill"></i> Facilities
        </a>
        <a href="{{ route('admin.amenities.index') }}" class="{{ request()->routeIs('admin.amenities.*') ? 'active' : '' }}">
            <i class="bi bi-box-fill"></i> Amenities
        </a>
        <a href="{{ route('admin.system-apps.index') }}" class="{{ request()->routeIs('admin.system-apps.*') ? 'active' : '' }}">
            <i class="bi bi-app-indicator"></i> System Apps
        </a>

        <div class="sidebar-heading mt-4">Requests</div>
        <a href="{{ route('admin.requests.dining') }}" class="{{ request()->routeIs('admin.requests.dining') ? 'active' : '' }}">
            <i class="bi bi-bag-check-fill"></i> Dining Orders
        </a>
        <a href="{{ route('admin.requests.amenities') }}" class="{{ request()->routeIs('admin.requests.amenities') ? 'active' : '' }}">
            <i class="bi bi-hand-thumbs-up-fill"></i> Amenity Requests
        </a>

        <div class="sidebar-heading mt-4">System</div>
        <a href="{{ route('admin.settings.global') }}" class="{{ request()->routeIs('admin.settings.global') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i> Settings
        </a>
        <a href="{{ route('admin.settings.marquee') }}" class="{{ request()->routeIs('admin.settings.marquee') ? 'active' : '' }}">
            <i class="bi bi-megaphone-fill"></i> Running Text
        </a>
    </div>
</div>

<div class="main-wrapper">
    <header class="top-navbar shadow-sm">
        <div class="d-flex align-items-center w-100">
            <h5 class="mb-0 fw-bold me-auto">@yield('page-title', 'Dashboard')</h5>
            
            <div class="dropdown">
                <button class="btn border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <div class="text-end d-none d-sm-block">
                        <small class="d-block text-muted">Welcome back,</small>
                        <span class="fw-bold">Administrator</span>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin&background=4361ee&color=fff" alt="" width="40" height="40" class="rounded-circle shadow-sm">
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-2">
                    <li><a class="dropdown-item rounded-2 py-2" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li>
                        <a class="dropdown-item rounded-2 py-2 text-danger font-bold" href="#" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="content-container">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap 5 Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
