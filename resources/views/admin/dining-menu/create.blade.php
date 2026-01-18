@extends('layouts.admin')

@section('page-title', 'Create Menu Item')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card premium-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">New Menu Item</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.dining-menu.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <x-larastrap::text name="name" label="Name" required />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::text name="name_en" label="Name (English)" />
                    </div>

                    <div class="mb-3">
                        <x-larastrap::textarea name="description" label="Description" />
                    </div>
                    
                    <div class="mb-3">
                        <x-larastrap::number name="price" label="Price (Rp)" value="0" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.dining-menu.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
