@extends('layouts.admin')

@section('page-title', 'Add Facility')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">New Hotel Facility</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.facilities.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <x-larastrap::text name="name" label="Facility Name (ID)" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="name_en" label="Facility Name (EN)" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description" label="Description (ID)" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description_en" label="Description (EN)" />
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="show_description" id="show_description" checked>
                        <label class="form-check-label" for="show_description">Show Description on TV</label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Facility</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
