@extends('layouts.admin')

@section('page-title', 'Dining Menu')

@section('content')
<div class="row mb-3">
    <div class="col-12 text-end">
        <a href="{{ route('admin.dining-menu.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add New Menu
        </a>
    </div>
</div>

<div class="card premium-card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">Dining Menu Catalog</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $item->name }}</div>
                            <small class="text-muted">{{ $item->name_en }}</small>
                        </td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.dining-menu.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.dining-menu.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="4" class="text-center text-muted py-4">No items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
