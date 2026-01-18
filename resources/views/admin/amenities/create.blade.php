@extends('layouts.admin')

@section('page-title', 'Add Amenity Item')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">New Amenity Configuration</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.amenities.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <x-larastrap::text name="name" label="Item Name (ID)" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="name_en" label="Item Name (EN)" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="category" label="Category" placeholder="e.g. Bathroom, Bedding, Food" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description" label="Description (ID)" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description_en" label="Description (EN)" />
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.amenities.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Amenity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
