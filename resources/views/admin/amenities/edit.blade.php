@extends('layouts.admin')

@section('page-title', 'Edit Amenity Item')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Edit Amenity Configuration</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.amenities.update', $amenity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <x-larastrap::text name="name" label="Item Name (ID)" :value="$amenity->name" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="name_en" label="Item Name (EN)" :value="$amenity->name_en" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="category" label="Category" :value="$amenity->category" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Icon / Image</label>
                        @if($amenity->icon_path)
                            <div class="mb-2">
                                <img src="{{ asset($amenity->icon_path) }}" alt="Current Icon" class="img-thumbnail" style="max-height: 80px">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Leave empty to keep current. Recommended: Transparent PNG or SVG</div>
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description" label="Description (ID)" :value="$amenity->description" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description_en" label="Description (EN)" :value="$amenity->description_en" />
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.amenities.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Amenity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
