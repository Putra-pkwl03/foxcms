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
                <form action="{{ route('admin.settings.global.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="section-header">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                        <h6>Launcher Control</h6>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Launcher Enabled Status</label>
                            <select name="launcher_enabled" class="form-select">
                                <option value="1" {{ ($settings['launcher_enabled'] ?? '') == '1' ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ ($settings['launcher_enabled'] ?? '') == '0' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            <small class="text-muted text-xs">If disabled, STB will show an offline message.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-larastrap::text name="launcher_version" label="Current Launcher Version" :value="$settings['launcher_version'] ?? '361'" />
                            <small class="text-muted text-xs">Set the version number here. Launcher will check this to decide if it needs to update.</small>
                        </div>
                    </div>

                    <div class="mb-5 p-4 bg-light rounded shadow-sm border">
                        <label class="form-label font-weight-bold text-primary mb-3">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Upload Launcher APK (OTA Update)
                        </label>
                        <input type="file" name="launcher_apk_file" class="form-control mb-3" accept=".apk">
                        
                        <div class="d-flex align-items-center py-2 px-3 bg-white rounded border">
                            <span class="badge bg-soft-info text-info me-3">Active OTA File:</span>
                            <code class="text-pink fw-bold">{{ $settings['launcher_apk_file'] ?? 'launcher_update.apk' }}</code>
                        </div>
                        
                        <div class="mt-3 small text-muted">
                            <i class="bi bi-info-circle-fill me-1 text-info"></i>
                            File yang diupload akan menggantikan <code>launcher_update.apk</code> di server. STB akan mendownload file ini jika versinya lebih baru.
                        </div>
                    </div>

                    <div class="section-header">
                        <i class="bi bi-chat-heart-fill"></i>
                        <h6>Custom Greeting Screen</h6>
                    </div>
                    
                    <div class="mb-4">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <x-larastrap::text name="custom_greeting_title" label="Greeting Title" :value="$settings['custom_greeting_title'] ?? ''" placeholder="e.g. Welcome to Our Hotel" />
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label">Welcome Message</label>
                            <textarea name="custom_welcome_greeting" class="form-control" rows="3" placeholder="Enter the main message shown on the home screen">{{ $settings['custom_welcome_greeting'] ?? '' }}</textarea>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label">Greeting Background Image</label>
                            <input type="file" name="custom_greeting_image" class="form-control">
                            <div class="mt-2 small">
                                <span class="badge bg-light text-muted border">Current File:</span>
                                <code class="ms-1">{{ $settings['custom_greeting_image'] ?? 'Default' }}</code>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="section-header">
                        <i class="bi bi-palette-fill"></i>
                        <h6>Branding & UI Assets</h6>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Home Wallpaper (.jpg/.png)</label>
                            <input type="file" name="launcher_home_bg" class="form-control">
                            <div class="mt-2 small italic">
                                <code>{{ $settings['launcher_home_bg'] ?? 'Default' }}</code>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Loading Logo (.png)</label>
                            <input type="file" name="loading_logo_url" class="form-control">
                            <div class="mt-2 small italic">
                                <code>{{ $settings['loading_logo_url'] ?? 'Default' }}</code>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-weight-bold">Intro Video (MP4)</label>
                        <input type="file" name="intro_video_url" class="form-control" accept="video/mp4">
                        <div class="mt-2 p-2 bg-light rounded small border-start border-4 border-info">
                            <i class="bi bi-play-circle-fill me-1 text-info"></i>
                            Current: <strong>{{ $settings['intro_video_url'] ?? 'Not Set' }}</strong>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                            <i class="bi bi-save-fill me-2"></i> Save All Settings
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
