@extends('super_admin.layouts.app')

@section('title', 'All Stores')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1">Registered Stores Registry</h1>
        <p class="text-muted small">Monitor active stores, subscription plans, and themes across the multi-tenant SaaS platform.</p>
    </div>
    <a href="{{ route('super_admin.create_tenant') }}" class="btn btn-primary btn-sm rounded-3 px-3">
        <i class="fas fa-plus me-2"></i> Create New Tenant
    </a>
</div>

<div class="card border shadow-sm rounded-3">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark fw-bold">Active Tenants Directory</h5>
        <span class="badge bg-light text-secondary border">{{ $tenants->total() }} total stores</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted small text-uppercase">
                <tr>
                    <th class="px-3 py-2 border-0 fw-semibold">ID</th>
                    <th class="px-3 py-2 border-0 fw-semibold">Site Name</th>
                    <th class="px-3 py-2 border-0 fw-semibold">Admin Info</th>
                    <th class="px-3 py-2 border-0 fw-semibold">Plan</th>
                    <th class="px-3 py-2 border-0 fw-semibold">Theme</th>
                    <th class="px-3 py-2 border-0 fw-semibold text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr>
                    <td class="px-3 py-3 fw-semibold text-dark">#{{ $tenant->id }}</td>
                    <td class="px-3 py-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded fw-bold">{{ $tenant->name ?? 'N/A' }}</span>
                    </td>
                    <td class="px-3 py-3">
                        @if($tenant->admin)
                            <div class="text-dark fw-semibold small">{{ $tenant->admin->name }}</div>
                            <div class="text-muted small" style="font-size: 11px;">{{ $tenant->admin->email }}</div>
                        @else
                            <div class="text-muted fw-semibold small">No Admin Registered</div>
                        @endif
                    </td>
                    <td class="px-3 py-3">
                        <span class="badge bg-success bg-opacity-10 text-success small text-capitalize fw-bold">{{ $tenant->plan ?? 'sprout' }}</span>
                    </td>
                    <td class="px-3 py-3">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary small text-capitalize fw-bold">{{ str_replace('_', ' ', $tenant->theme ?? 'aura_luxe') }}</span>
                    </td>
                    <td class="px-3 py-3 text-end">
                        <a href="{{ route('admin.dashboard', ['tenant' => $tenant->id]) }}" class="btn btn-sm btn-outline-secondary rounded-3">
                            <i class="fas fa-eye me-1"></i> Admin Panel
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted small">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-users-slash fs-1 mb-3 opacity-25"></i>
                            <p class="mb-0">No tenants registered on the platform yet.</p>
                            <a href="{{ route('super_admin.create_tenant') }}" class="btn btn-link btn-sm text-decoration-none mt-2">Create your first tenant</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tenants->hasPages())
    <div class="card-footer bg-white border-top py-3">
        {{ $tenants->links() }}
    </div>
    @endif
</div>
@endsection
