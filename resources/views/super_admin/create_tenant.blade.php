@extends('super_admin.layouts.app')

@section('title', 'Create New Tenant')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1">Create New Tenant</h1>
        <p class="text-muted small">Add a new admin user and site configuration.</p>
    </div>
    <a href="{{ route('super_admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('super_admin.store_tenant') }}" method="POST">
                    @csrf
                    
                    <h5 class="mb-4 text-dark fw-bold border-bottom pb-2">Tenant Details</h5>

                    <div class="mb-3">
                        <label for="site_name" class="form-label fw-medium small text-secondary">Site Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="site_name" name="site_name" placeholder="e.g. My Perfume Shop" required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium small text-secondary">Admin Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium small text-secondary">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="admin@example.com" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="plan" class="form-label fw-medium small text-secondary">Subscription Plan <span class="text-danger">*</span></label>
                            <select class="form-select" id="plan" name="plan" required>
                                <option value="sprout">Sprout — $9/mo</option>
                                <option value="maison" selected>Maison — $19/mo</option>
                                <option value="heritage">Heritage — $49/mo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="theme" class="form-label fw-medium small text-secondary">Storefront Theme <span class="text-danger">*</span></label>
                            <select class="form-select" id="theme" name="theme" required>
                                <option value="aura_luxe">Aura Luxe (v3)</option>
                                <option value="velvet_dark">Velvet Dark (v2)</option>
                                <option value="editorial_cream">Editorial Cream (v4)</option>
                                <option value="modern_minimal">Modern Minimal (v1)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-medium small text-secondary">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Create a strong password" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary fw-medium py-2">Create Tenant Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
