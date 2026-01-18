@extends('layouts.admin')

@section('page-title', 'Entertainment Apps')

@section('content')
<div class="row mb-3">
    <div class="col-12 text-end">
        <a href="{{ route('admin.system-apps.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add New App
        </a>
    </div>
</div>

<div class="card premium-card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">App Configurations</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Icon</th>
                        <th>App Name</th>
                        <th>Package / Key</th>
                        <th>Order</th>
                        <th>Visible</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($apps as $app)
                    <tr>
                        <td>
                            <img src="{{ Str::startsWith($app->icon_path, 'http') ? $app->icon_path : url($app->icon_path) }}" alt="" width="40" height="40" class="rounded border">
                        </td>
                        <td>
                            <div class="fw-bold">{{ $app->app_name }}</div>
                            <small class="text-muted">{{ $app->app_name_en }}</small>
                        </td>
                        <td>
                            <code>{{ $app->android_package ?: $app->app_key }}</code>
                        </td>
                        <td>{{ $app->sort_order }}</td>
                        <td>
                            <span class="badge bg-{{ $app->is_visible ? 'success' : 'secondary' }}">
                                {{ $app->is_visible ? 'Visible' : 'Hidden' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.system-apps.edit', $app->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.system-apps.destroy', $app->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="6" class="text-center text-muted py-4">No apps configured.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
