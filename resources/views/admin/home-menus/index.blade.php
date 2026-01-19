@extends('layouts.admin')

@section('page-title', 'Home Menus')

@section('content')
<div class="row mb-3">
    <div class="col-12 text-end">
        <a href="{{ route('admin.home-menus.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add New Menu
        </a>
    </div>
</div>

<div class="card premium-card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">Home Menu Configuration (Bottom Bar)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px">Icon</th>
                        <th>Name</th>
                        <th>Key / Action</th>
                        <th>Sort</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                    <tr>
                        <td>
                            @if($menu->icon_path)
                                <img src="{{ asset($menu->icon_path) }}" alt="" style="height: 40px; width: 40px; object-fit: contain; background: #f8f9fa; border-radius: 8px; padding: 5px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 40px; width: 40px; border-radius: 8px;">
                                    <i class="bi bi-app"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $menu->menu_name }}</div>
                            <small class="text-muted">{{ $menu->menu_name_en }}</small>
                        </td>
                        <td>
                            <code>{{ $menu->menu_key }}</code><br>
                            <small class="text-muted">{{ $menu->action_type }}: {{ $menu->action_value }}</small>
                        </td>
                        <td>{{ $menu->sort_order }}</td>
                        <td>
                            <span class="badge bg-{{ $menu->is_active ? 'success' : 'secondary' }}">
                                {{ $menu->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.home-menus.edit', $menu->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.home-menus.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="6" class="text-center text-muted py-4">No menu items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
