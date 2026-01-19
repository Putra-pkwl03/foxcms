@extends('layouts.admin')

@section('page-title', 'Hotel Facilities')

@section('content')
<div class="row mb-3">
    <div class="col-12 text-end">
        <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add Facility
        </a>
    </div>
</div>

<div class="card premium-card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">Hotel Facilities Catalog</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $facility)
                    <tr>
                        <td>
                            @if($facility->icon_path)
                                <img src="{{ url($facility->icon_path) }}" alt="" width="40" height="40" class="rounded border">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center border rounded" style="width:40px; height:40px;">
                                    <i class="bi bi-building text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $facility->name }}</div>
                            <small class="text-muted">{{ $facility->name_en }}</small>
                        </td>
                        <td><small>{{ Str::limit($facility->description, 50) }}</small></td>
                        <td>
                            <span class="badge bg-{{ $facility->is_active ? 'success' : 'secondary' }}">
                                {{ $facility->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.facilities.edit', $facility->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="5" class="text-center text-muted py-4">No facilities found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
