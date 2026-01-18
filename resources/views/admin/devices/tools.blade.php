@extends('layouts.admin')

@section('page-title', 'Device Tools')

@section('content')
<style>
    .tool-card {
        border-radius: 1rem !important;
        border: none !important;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
    }
    .tool-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
    }
    .tool-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }
</style>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card premium-card border-0 shadow-sm p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-primary-subtle text-primary rounded-3 me-3">
                            <i class="bi bi-gear-wide-connected fs-3"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">Device Control Center</h3>
                            <p class="text-muted mb-0">Manage and diagnose: <strong>{{ $device->device_name }}</strong> ({{ $device->device_id }})</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.devices.index') }}" class="btn btn-light border px-4">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Remote Restart -->
        <div class="col-md-4">
            <div class="card tool-card shadow-sm p-4" onclick="executeCommand('reboot', 'Reboot Device?')">
                <div class="tool-icon bg-danger-subtle text-danger">
                    <i class="bi bi-arrow-clockwise fs-2"></i>
                </div>
                <h5 class="fw-bold">Remote Restart</h5>
                <p class="text-muted small">Reboot the device remotely. This will disconnect current session.</p>
                <div class="mt-auto">
                    <button class="btn btn-outline-danger w-100 rounded-3">Execute Restart</button>
                </div>
            </div>
        </div>

        <!-- Clear Cache / Guest Data -->
        <div class="col-md-4">
            <div class="card tool-card shadow-sm p-4" onclick="executeCommand('clear_cache', 'Clear all guest data & cache?')">
                <div class="tool-icon bg-warning-subtle text-warning">
                    <i class="bi bi-trash3 fs-2"></i>
                </div>
                <h5 class="fw-bold">Clear Guest Data</h5>
                <p class="text-muted small">Hapus cache dan data login semua aplikasi multimedia (Chrome, YouTube, dll).</p>
                <div class="mt-auto">
                    <button class="btn btn-outline-warning w-100 rounded-3 text-dark">Clear Data</button>
                </div>
            </div>
        </div>

        <!-- Set Device Owner -->
        <div class="col-md-4">
            <div class="card tool-card shadow-sm p-4" onclick="executeCommand('set_owner', 'Set as Device Owner (Kiosk Mode)?')">
                <div class="tool-icon bg-success-subtle text-success">
                    <i class="bi bi-shield-check fs-2"></i>
                </div>
                <h5 class="fw-bold">Kiosk Mode (Owner)</h5>
                <p class="text-muted small">Set aplikasi launcher sebagai Device Owner untuk mengunci fungsi sistem.</p>
                <div class="mt-auto">
                    <button class="btn btn-outline-success w-100 rounded-3">Activate Owner</button>
                </div>
            </div>
        </div>

        <!-- Return to Home -->
        <div class="col-md-4">
            <div class="card tool-card shadow-sm p-4" onclick="executeCommand('home', 'Return to Launcher Home?')">
                <div class="tool-icon bg-primary-subtle text-primary">
                    <i class="bi bi-house-door fs-2"></i>
                </div>
                <h5 class="fw-bold">Home / Reset</h5>
                <p class="text-muted small">Paksa perangkat untuk kembali ke layar utama TakeOff Launcher.</p>
                <div class="mt-auto">
                    <button class="btn btn-outline-primary w-100 rounded-3">Go Home</button>
                </div>
            </div>
        </div>

        <!-- Default Launcher -->
        <div class="col-md-4">
            <div class="card tool-card shadow-sm p-4" onclick="executeCommand('set_default_launcher', 'Set as Default System Launcher?')">
                <div class="tool-icon bg-info-subtle text-info">
                    <i class="bi bi-rocket-takeoff fs-2"></i>
                </div>
                <h5 class="fw-bold">Default Launcher</h5>
                <p class="text-muted small">Matikan launcher bawaan Android TV dan jadikan ini sebagai default.</p>
                <div class="mt-auto">
                    <button class="btn btn-outline-info w-100 rounded-3">Set Default</button>
                </div>
            </div>
        </div>

        <!-- Terminal / Logs -->
        <div class="col-md-4">
            <div class="card tool-card shadow-sm p-4" onclick="viewLogs()">
                <div class="tool-icon bg-dark-subtle text-dark">
                    <i class="bi bi-terminal fs-2"></i>
                </div>
                <h5 class="fw-bold">View Logs</h5>
                <p class="text-muted small">Ambil logcat sistem terakhir untuk melakukan diagnosa masalah.</p>
                <div class="mt-auto">
                    <button class="btn btn-outline-dark w-100 rounded-3">Fetch Logs</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function viewLogs() {
        Swal.fire({
            title: 'Fetching System Logs...',
            text: 'Please wait, grabbing latest 100 lines.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                fetch('{{ route("admin.devices.tools.execute", $device->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ command: 'logs' })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        Swal.fire({
                            title: 'System Logs (Logcat)',
                            html: `<div class="bg-black text-success p-3 rounded text-start font-monospace small overflow-auto" style="height: 400px; white-space: pre-wrap;">${result.data}</div>`,
                            width: '80%',
                            confirmButtonText: 'Close'
                        });
                    } else {
                        Swal.fire('Failed!', result.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', `Failed to fetch logs: ${error}`, 'error');
                });
            }
        });
    }

    function executeCommand(command, confirmMessage) {
        Swal.fire({
            title: 'Are you sure?',
            text: confirmMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, execute!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch('{{ route("admin.devices.tools.execute", $device->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ command: command })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error}`)
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.status === 'success') {
                    Swal.fire('Success!', result.value.message, 'success');
                } else {
                    Swal.fire('Failed!', result.value.message, 'error');
                }
            }
        });
    }
</script>
@endsection
