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
                <form action="{{ route('admin.info.update', $info->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
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
