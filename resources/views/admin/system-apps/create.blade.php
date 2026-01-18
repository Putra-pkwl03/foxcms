@extends('layouts.admin')

@section('page-title', 'Add Entertainment App')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">New App Configuration</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.system-apps.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <x-larastrap::text name="app_name" label="App Name (ID)" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="app_name_en" label="App Name (EN)" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="app_key" label="Unique Key" placeholder="e.g. netflix" required />
                        <small class="text-muted">Internal key used by the launcher.</small>
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="android_package" label="Android Package Name" placeholder="e.g. com.netflix.ninja" />
                        <small class="text-muted">Required if this is an external Android app.</small>
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="icon_path" label="Icon URL or Path" placeholder="e.g. img/netflix.png" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::number name="sort_order" label="Sort Order" value="0" required />
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_visible" id="is_visible" checked>
                        <label class="form-check-label" for="is_visible">Visible on Launcher</label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.system-apps.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save App</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
