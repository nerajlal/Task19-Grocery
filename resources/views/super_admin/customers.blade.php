@extends('super_admin.layouts.app')

@section('title', 'Global Customers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1">Global Customers Registry</h1>
        <p class="text-muted small">Manage all registered accounts and shoppers across all multi-tenant stores.</p>
    </div>
</div>

<div class="card border shadow-sm rounded-3">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark fw-bold">Customer Directory</h5>
        <span class="badge bg-light text-secondary border">{{ $customers->total() }} total customers</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted small text-uppercase">
                <tr>
                    <th class="px-3 py-2 border-0 fw-semibold">ID</th>
                    <th class="px-3 py-2 border-0 fw-semibold">Customer Name</th>
                    <th class="px-3 py-2 border-0 fw-semibold">Email</th>
                    <th class="px-3 py-2 border-0 fw-semibold">Store / Tenant ID</th>
                    <th class="px-3 py-2 border-0 fw-semibold">Registered At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td class="px-3 py-3 fw-semibold text-dark">#{{ $customer->id }}</td>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center bg-secondary bg-opacity-10 text-secondary rounded-circle fw-bold text-uppercase" style="width: 32px; height: 32px; font-size: 12px;">
                                {{ substr($customer->name, 0, 2) }}
                            </div>
                            <span class="fw-semibold text-dark">{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td class="px-3 py-3 text-muted">{{ $customer->email }}</td>
                    <td class="px-3 py-3">
                        <span class="badge bg-info bg-opacity-10 text-info fw-bold">Tenant #{{ $customer->tenant_id ?? 1 }}</span>
                    </td>
                    <td class="px-3 py-3 text-muted small">{{ $customer->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted small">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-users-slash fs-1 mb-3 opacity-25"></i>
                            <p class="mb-0">No customers registered on the platform yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="card-footer bg-white border-top py-3">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
