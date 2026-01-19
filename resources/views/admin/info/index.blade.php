@extends('layouts.admin')

@section('page-title', 'Hotel Information')

@section('content')
<div class="row mb-3">
    <div class="col-12 text-end">
        <a href="{{ route('admin.info.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add Info Page
        </a>
    </div>
</div>

<div class="card premium-card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">Information Pages</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($infos as $info)
                    <tr>
                        <td>
                            @if($info->icon_path)
                                <img src="{{ asset($info->icon_path) }}" class="rounded shadow-sm" style="width:40px; height:40px; object-fit:cover;" alt="">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center border rounded" style="width:40px; height:40px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $info->title }}</div>
                            <small class="text-muted">{{ $info->title_en }}</small>
                        </td>
                        <td>{{ $info->sort_order }}</td>
                        <td>
                            <span class="badge bg-{{ $info->show_description ? 'success' : 'secondary' }}">
                                {{ $info->show_description ? 'Visible' : 'Hidden' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.info.edit', $info->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.info.destroy', $info->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="5" class="text-center text-muted py-4">No information pages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
