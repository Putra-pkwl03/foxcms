@extends('layouts.admin')

@section('page-title', 'Edit Facility')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Edit Hotel Facility</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <x-larastrap::text name="name" label="Facility Name (ID)" :value="$facility->name" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="name_en" label="Facility Name (EN)" :value="$facility->name_en" />
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Image / Icon</label>
                        @if($facility->icon_path)
                            <div class="mb-2">
                                <img src="{{ asset($facility->icon_path) }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Leave empty to keep current. Recommended size: 800x600px</div>
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description" label="Description (ID)" :value="$facility->description" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description_en" label="Description (EN)" :value="$facility->description_en" />
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $facility->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="show_description" id="show_description" {{ $facility->show_description ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_description">Show Description on TV</label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Facility</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
