@extends('layouts.admin')

@section('page-title', 'Create Home Menu')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Menu Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.home-menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Menu Key (Unique ID)</label>
                            <input type="text" name="menu_key" class="form-control @error('menu_key') is-invalid @enderror" value="{{ old('menu_key') }}" placeholder="e.g., tv, apps, info" required>
                            @error('menu_key') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name (ID)</label>
                            <input type="text" name="menu_name" class="form-control @error('menu_name') is-invalid @enderror" value="{{ old('menu_name') }}" placeholder="e.g., TV Langsung" required>
                            @error('menu_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Name (EN)</label>
                            <input type="text" name="menu_name_en" class="form-control" value="{{ old('menu_name_en') }}" placeholder="e.g., Live TV">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Action Type</label>
                            <select name="action_type" class="form-select @error('action_type') is-invalid @enderror" required>
                                <option value="dialog" {{ old('action_type') == 'dialog' ? 'selected' : '' }}>Dialog (Modals)</option>
                                <option value="function" {{ old('action_type') == 'function' ? 'selected' : '' }}>Function (Internal Logic)</option>
                                <option value="app" {{ old('action_type') == 'app' ? 'selected' : '' }}>Open Android App</option>
                            </select>
                            @error('action_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Action Value</label>
                            <input type="text" name="action_value" class="form-control" value="{{ old('action_value') }}" placeholder="e.g., info, openTv, com.package.name">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Icon Image</label>
                        <input type="file" name="icon" class="form-control @error('icon') is-invalid @enderror">
                        <small class="text-muted">Recommended: PNG / SVG with transparent background (512x512)</small>
                        @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked>
                            <label class="form-check-label" for="isActive">Active</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.home-menus.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
