@extends('layouts.admin')

@section('page-title', 'Edit Home Menu')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Edit: {{ $menu->menu_name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.home-menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Menu Key (Unique ID)</label>
                            <input type="text" name="menu_key" class="form-control @error('menu_key') is-invalid @enderror" value="{{ old('menu_key', $menu->menu_key) }}" required>
                            @error('menu_key') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $menu->sort_order) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name (ID)</label>
                            <input type="text" name="menu_name" class="form-control @error('menu_name') is-invalid @enderror" value="{{ old('menu_name', $menu->menu_name) }}" required>
                            @error('menu_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Name (EN)</label>
                            <input type="text" name="menu_name_en" class="form-control" value="{{ old('menu_name_en', $menu->menu_name_en) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Action Type</label>
                            <select name="action_type" class="form-select @error('action_type') is-invalid @enderror" required>
                                <option value="dialog" {{ old('action_type', $menu->action_type) == 'dialog' ? 'selected' : '' }}>Dialog (Modals)</option>
                                <option value="function" {{ old('action_type', $menu->action_type) == 'function' ? 'selected' : '' }}>Function (Internal Logic)</option>
                                <option value="app" {{ old('action_type', $menu->action_type) == 'app' ? 'selected' : '' }}>Open Android App</option>
                            </select>
                            @error('action_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Action Value</label>
                            <input type="text" name="action_value" class="form-control" value="{{ old('action_value', $menu->action_value) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Icon Image</label>
                        @if($menu->icon_path)
                        <div class="mb-2">
                            <img src="{{ asset($menu->icon_path) }}" alt="current icon" style="height: 60px; background: #f8f9fa; border-radius: 8px; padding: 10px;">
                        </div>
                        @endif
                        <input type="file" name="icon" class="form-control @error('icon') is-invalid @enderror">
                        <small class="text-muted">Leave empty to keep current icon. PNG / SVG recommended.</small>
                        @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ $menu->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">Active</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.home-menus.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
