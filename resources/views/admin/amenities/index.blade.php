@extends('layouts.admin')

@section('page-title', 'Room Amenities')

@section('content')
<div class="row mb-3">
    <div class="col-12 text-end">
        <a href="{{ route('admin.amenities.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add Amenity Item
        </a>
    </div>
</div>

<div class="card premium-card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">Amenities Catalog</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px">Icon</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($amenities as $amenity)
                    <tr>
                        <td>
                            @if($amenity->icon_path)
                                <img src="{{ asset($amenity->icon_path) }}" alt="" style="height: 40px; width: 40px; object-fit: contain;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 40px; width: 40px; border-radius: 4px;">
                                    <i class="bi bi-box"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $amenity->name }}</div>
                            <small class="text-muted">{{ $amenity->name_en }}</small>
                        </td>
                        <td><span class="badge bg-info text-dark">{{ Str::headline($amenity->category) }}</span></td>
                        <td><small>{{ Str::limit($amenity->description, 50) }}</small></td>
                        <td>
                            <a href="{{ route('admin.amenities.edit', $amenity->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.amenities.destroy', $amenity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No amenity items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
