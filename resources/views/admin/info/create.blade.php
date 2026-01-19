@extends('layouts.admin')

@section('page-title', 'Add Info Page')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">New Information Page</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.info.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Banner Image / Icon</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        <div class="form-text">Recommended size: 1920x1080 for full slide or square for icon.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <x-larastrap::text name="title" label="Title (ID)" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="title_en" label="Title (EN)" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description" label="Content (ID)" rows="8" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description_en" label="Content (EN)" rows="8" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::number name="sort_order" label="Sort Order" value="0" required />
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="show_description" id="show_description" checked>
                        <label class="form-check-label" for="show_description">Show on TV</label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.info.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Information</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
