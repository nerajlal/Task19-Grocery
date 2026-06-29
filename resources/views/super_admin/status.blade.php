@extends('super_admin.layouts.app')

@section('title', 'System Status')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1">System Health & Status</h1>
        <p class="text-muted small">Verify platform server status, database connections, environment flags, and global table statistics.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Server Environment Info -->
    <div class="col-12 col-md-6">
        <div class="card border shadow-sm h-100 rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 text-dark fw-bold">Environment Environment</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm align-middle table-borderless small mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted py-2">PHP Version</td>
                            <td class="text-dark fw-bold py-2 text-end">{{ $statusInfo['php_version'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-2">Laravel Version</td>
                            <td class="text-dark fw-bold py-2 text-end">v{{ $statusInfo['laravel_version'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-2">Application Environment</td>
                            <td class="text-dark fw-bold py-2 text-end text-capitalize"><span class="badge bg-primary">{{ $statusInfo['app_env'] }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted py-2">Debug Mode</td>
                            <td class="text-dark fw-bold py-2 text-end"><span class="badge bg-warning bg-opacity-10 text-warning">{{ $statusInfo['debug_mode'] }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Database Info -->
    <div class="col-12 col-md-6">
        <div class="card border shadow-sm h-100 rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 text-dark fw-bold">Database Configuration</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm align-middle table-borderless small mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted py-2">Connection Status</td>
                            <td class="text-dark fw-bold py-2 text-end">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success"><i class="fas fa-link me-1"></i> {{ $statusInfo['db_connection'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted py-2">Database Name</td>
                            <td class="text-dark fw-bold py-2 text-end">{{ $statusInfo['database_name'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-2">Database Scoping Trait</td>
                            <td class="text-dark fw-bold py-2 text-end text-success"><i class="fas fa-check-circle me-1"></i> Enabled (BelongsToTenant)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Global Table Stats -->
    <div class="col-12">
        <div class="card border shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 text-dark fw-bold">Global Database Ledger Accounts</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-6 col-lg-3">
                        <div class="p-3 bg-light rounded-3 border">
                            <h3 class="fw-bold text-dark mb-1">{{ number_format($statusInfo['total_tenants']) }}</h3>
                            <span class="text-muted small text-uppercase fw-bold" style="font-size: 10px;">Stores</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-3 bg-light rounded-3 border">
                            <h3 class="fw-bold text-dark mb-1">{{ number_format($statusInfo['total_products']) }}</h3>
                            <span class="text-muted small text-uppercase fw-bold" style="font-size: 10px;">Products</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-3 bg-light rounded-3 border">
                            <h3 class="fw-bold text-dark mb-1">{{ number_format($statusInfo['total_orders']) }}</h3>
                            <span class="text-muted small text-uppercase fw-bold" style="font-size: 10px;">Orders</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-3 bg-light rounded-3 border">
                            <h3 class="fw-bold text-dark mb-1">{{ number_format($statusInfo['total_users']) }}</h3>
                            <span class="text-muted small text-uppercase fw-bold" style="font-size: 10px;">Accounts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
