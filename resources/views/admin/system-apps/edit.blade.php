@extends('layouts.admin')

@section('page-title', 'Edit App')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Edit App Configuration</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.system-apps.update', $app->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <x-larastrap::text name="app_name" label="App Name (ID)" :value="$app->app_name" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="app_name_en" label="App Name (EN)" :value="$app->app_name_en" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="app_key" label="Unique Key" :value="$app->app_key" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="android_package" label="Android Package Name" :value="$app->android_package" />
                    </div>
                    
                    <div class="mb-3">
                        <x-larastrap::text name="apk_url" label="APK Download URL" :value="$app->apk_url" placeholder="https://example.com/netflix.apk" />
                        <small class="text-muted">Direct link to download the APK if the app is not installed on STB.</small>
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="icon_path" label="Icon URL or Path" :value="$app->icon_path" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::number name="sort_order" label="Sort Order" :value="$app->sort_order" required />
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_visible" id="is_visible" {{ $app->is_visible ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_visible">Visible on Launcher</label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.system-apps.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update App</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
