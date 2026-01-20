@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-primary"></i>Log Aktivitas Admin
                            </h5>
                            <div class="badge bg-info text-white">Data via Firebase Realtime Database</div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4">Waktu</th>
                                        <th>Admin</th>
                                        <th>Aksi</th>
                                        <th>Deskripsi</th>
                                        <th>IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td class="px-4">
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($log['created_at'])->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') }}
                                                </small>
                                            </td>
                                            <td>
                                                <strong>{{ $log['admin_name'] }}</strong><br>
                                                <small class="text-muted">{{ $log['admin_email'] }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $badgeClass = 'bg-secondary';
                                                    if (str_contains(strtolower($log['action']), 'create'))
                                                        $badgeClass = 'bg-success';
                                                    if (str_contains(strtolower($log['action']), 'update'))
                                                        $badgeClass = 'bg-warning text-dark';
                                                    if (str_contains(strtolower($log['action']), 'delete'))
                                                        $badgeClass = 'bg-danger';
                                                    if (str_contains(strtolower($log['action']), 'approve'))
                                                        $badgeClass = 'bg-info';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $log['action'] }}</span>
                                            </td>
                                            <td>{{ $log['description'] }}</td>
                                            <td><small class="text-muted">{{ $log['ip_address'] }}</small></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="fas fa-info-circle fa-3x text-light mb-3"></i>
                                                <p class="text-muted">Belum ada aktivitas yang tercatat di Firebase.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection