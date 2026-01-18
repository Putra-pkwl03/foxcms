@extends('layouts.admin')

@section('page-title', 'Global Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="premium-card">
            <div class="card-header border-0 pb-0">
                <h5>System Configuration</h5>
                <p class="text-muted small mb-0">Manage launcher behavior and hotel-wide visual settings.</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.global.update') }}" method="POST">
                    @csrf
                    
                    <div class="section-header">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                        <h6>Launcher Control</h6>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Launcher Enabled</label>
                            <select name="launcher_enabled" class="form-select">
                                <option value="1" {{ ($settings['launcher_enabled'] ?? '') == '1' ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ ($settings['launcher_enabled'] ?? '') == '0' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            <small class="text-muted text-xs">Disable to prevent devices from opening the launcher.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-larastrap::text name="launcher_version" label="Launcher Version" :value="$settings['launcher_version'] ?? '1.0.0'" />
                            <small class="text-muted text-xs">Target version for OTA updates.</small>
                        </div>
                    </div>

                    <div class="section-header">
                        <i class="bi bi-chat-heart-fill"></i>
                        <h6>Custom Greeting</h6>
                    </div>
                    
                    <div class="mb-4">
                        <div class="mb-3">
                            <x-larastrap::text name="custom_greeting_title" label="Greeting Title" :value="$settings['custom_greeting_title'] ?? ''" placeholder="e.g. Welcome to Our Hotel" />
                        </div>

                        <div class="mb-3">
                            <x-larastrap::textarea name="custom_welcome_greeting" label="Welcome Message" rows="4" placeholder="Enter the main message shown on the home screen">{{ $settings['custom_welcome_greeting'] ?? '' }}</x-larastrap::textarea>
                        </div>

                        <div class="mb-3">
                            <x-larastrap::text name="custom_greeting_image" label="Greeting Image URL/Path" :value="$settings['custom_greeting_image'] ?? ''" placeholder="https://example.com/image.jpg" />
                        </div>
                    </div>

                    <div class="section-header">
                        <i class="bi bi-palette-fill"></i>
                        <h6>Branding & UI</h6>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <x-larastrap::text name="launcher_home_bg" label="Home Background URL/Path" :value="$settings['launcher_home_bg'] ?? ''" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <x-larastrap::text name="loading_logo_url" label="Loading Logo URL/Path" :value="$settings['loading_logo_url'] ?? ''" />
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                            <i class="bi bi-save-fill me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
@endsection
