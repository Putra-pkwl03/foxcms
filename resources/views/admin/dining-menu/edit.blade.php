@extends('layouts.admin')

@section('page-title', 'Edit Menu Item')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Edit Menu Item</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.dining-menu.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <x-larastrap::text name="name" label="Name" :value="$item->name" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="name_en" label="Name (English)" :value="$item->name_en" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description" label="Description" :value="$item->description" />
                    </div>
                    
                    <div class="mb-3">
                        <x-larastrap::number name="price" label="Price (Rp)" :value="$item->price" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        @if($item->image_url)
                            <div class="mb-2">
                                <img src="{{ asset($item->image_url) }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Leave empty to keep current image.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ $item->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $item->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.dining-menu.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
