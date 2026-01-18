@extends('layouts.admin')

@section('page-title', 'Register Device')

@section('content')
<style>
    .form-section-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6c757d;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
    }
    .form-section-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #e9ecef;
        margin-left: 1rem;
    }
    .form-group-custom {
        margin-bottom: 1.5rem;
    }
    .form-group-custom label {
        display: block;
        font-weight: 600;
        color: #344767;
        margin-bottom: 0.6rem;
        font-size: 0.9rem;
    }
    .form-group-custom label i {
        color: #5e72e4;
        margin-right: 6px;
    }
    .custom-input {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #f8f9fa;
        background-clip: padding-box;
        border: 1px solid #dee2e6;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
    }
    .custom-input:focus {
        color: #495057;
        background-color: #fff;
        border-color: #5e72e4;
        outline: 0;
        box-shadow: 0 0 0 4px rgba(94, 114, 228, 0.1);
    }
    .btn-submit {
        background: linear-gradient(310deg, #5e72e4, #825ee4);
        border: none;
        padding: 0.8rem 2.5rem;
        border-radius: 0.75rem;
        font-weight: 700;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        color: white;
    }
    .btn-cancel {
        border-radius: 0.75rem;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        color: #8392ab;
        background: #fff;
        border: 1px solid #e9ecef;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-cancel:hover {
        background: #f8f9fa;
        color: #67748e;
    }
    .premium-card {
        border-radius: 1.25rem !important;
        border: none !important;
        box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05) !important;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card premium-card">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-primary-subtle text-primary rounded-3 me-3">
                            <i class="bi bi-display fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-dark">Register New Device</h4>
                            <p class="text-muted small mb-0">Input detail perangkat Smart TV atau STB baru.</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.devices.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-section-title">Identitas Perangkat</div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label><i class="bi bi-hash"></i> Device ID <span class="text-danger">*</span></label>
                                    <input type="text" name="device_id" class="custom-input @error('device_id') is-invalid @enderror" value="{{ old('device_id') }}" placeholder="Misal: TV-QMEK3X" required>
                                    <div class="small text-muted mt-2">ID unik yang tampil di layar TV.</div>
                                    @error('device_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label><i class="bi bi-qr-code-scan"></i> Registration Code</label>
                                    <input type="text" name="registration_code" class="custom-input @error('registration_code') is-invalid @enderror" value="{{ old('registration_code') }}" placeholder="Biarkan kosong untuk otomatis">
                                    <div class="small text-muted mt-2">Kode pendaftaran manual (opsional).</div>
                                    @error('registration_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-section-title mt-4">Pengaturan & Lokasi</div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group-custom">
                                    <label><i class="bi bi-info-circle"></i> Nama Perangkat <span class="text-danger">*</span></label>
                                    <input type="text" name="device_name" class="custom-input @error('device_name') is-invalid @enderror" value="{{ old('device_name') }}" placeholder="Misal: LG Smart TV - Lobby" required>
                                    @error('device_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-custom">
                                    <label><i class="bi bi-door-open"></i> Nomor Kamar <span class="text-danger">*</span></label>
                                    <input type="text" name="room_number" class="custom-input @error('room_number') is-invalid @enderror" value="{{ old('room_number') }}" placeholder="101" required>
                                    @error('room_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group-custom mt-2">
                            <label><i class="bi bi-pencil-square"></i> Catatan Internal</label>
                            <textarea name="notes" class="custom-input" rows="3" placeholder="Informasi tambahan mengenai perangkat ini...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('admin.devices.index') }}" class="btn btn-cancel">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="bi bi-plus-circle-fill me-1"></i> Simpan Perangkat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
