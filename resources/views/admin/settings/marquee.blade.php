@extends('layouts.admin')

@section('page-title', 'Running Text')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="premium-card">
            <div class="card-header border-0 pb-0">
                <h5>Manage Marquee Text</h5>
                <p class="text-muted small mb-0">Customize the scrolling announcement bar shown on guest TVs.</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.marquee.update') }}" method="POST">
                    @csrf
                    
                    <div class="section-header">
                        <i class="bi bi-megaphone-fill"></i>
                        <h6>Display Content</h6>
                    </div>

                    <div class="mb-4">
                        <x-larastrap::textarea name="content" label="Running Text Message" rows="3" required placeholder="Enter the announcement text here...">{{ $marquee?->content }}</x-larastrap::textarea>
                        <small class="text-muted text-xs">This message will scroll horizontally at the bottom of the TV screen.</small>
                    </div>
                    
                    <div class="mb-4 p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
                        <div>
                            <label class="form-label mb-0">Visibility Status</label>
                            <p class="text-muted small mb-0">Toggle whether the marquee is currently visible on TVs.</p>
                        </div>
                        <div class="form-check form-switch fs-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $marquee?->is_active ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                            <i class="bi bi-save-fill me-2"></i> Update Marquee
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="premium-card mt-4 bg-dark text-white p-0 border-0 shadow-lg">
            <div class="card-header border-bottom border-secondary border-opacity-25 py-3">
                <div class="d-flex align-items-center">
                    <div class="dot bg-danger me-2" style="width: 10px; height: 10px; border-radius: 50%;"></div>
                    <h5 class="card-title mb-0 text-white-50">TV Screen Preview</h5>
                </div>
            </div>
            <div class="card-body p-0 position-relative" style="height: 120px; background: url('https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?auto=format&fit=crop&q=80&w=1000') center/cover;">
                <div class="position-absolute bottom-0 w-100 bg-primary bg-opacity-75 py-2 text-white overflow-hidden shadow-lg border-top border-white border-opacity-25" style="backdrop-filter: blur(8px);">
                    <marquee scrollamount="8" class="fw-bold">{{ $marquee?->content ?: 'Running text announcement will scroll here once configured...' }}</marquee>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
