@extends('layouts.admin')

@section('page-title', 'Edit Info Page')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Edit Information Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Banner Image / Icon</label>
                        @if($info->icon_path)
                            <div class="mb-2">
                                <img src="{{ asset($info->icon_path) }}" class="img-thumbnail" style="max-height: 150px;" alt="Current Image">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        <div class="form-text">Leave empty to keep the current image. Recommended: 1920x1080.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <x-larastrap::text name="title" label="Title (ID)" :value="$info->title" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="title_en" label="Title (EN)" :value="$info->title_en" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description" label="Content (ID)" rows="8" :value="$info->description" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description_en" label="Content (EN)" rows="8" :value="$info->description_en" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::number name="sort_order" label="Sort Order" :value="$info->sort_order" required />
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="show_description" id="show_description" {{ $info->show_description ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_description">Show on TV</label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.info.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Information</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
