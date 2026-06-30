@extends('layouts.admin')

@section('title', 'Storefront Pages Settings')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Storefront Pages Settings</h1>
            <p class="text-muted">Manage the content for your About Us, Contact, Shipping, Return Policies, and Terms of Service pages.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.settings.storefront.update') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Left Side: About & Contact -->
            <div class="col-lg-8">
                <!-- About Page Settings -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header py-3 d-flex align-items-center">
                        <i class="fa-solid fa-address-card me-2 shopify-green"></i>
                        <h5 class="m-0 fw-bold">About Us Page Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="about_title" class="form-label fw-semibold">About Page Hero Title</label>
                            <input type="text" class="form-control @error('about_title') is-invalid @enderror" id="about_title" name="about_title" value="{{ old('about_title', $tenant->about_title) }}" required>
                            @error('about_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="about_text" class="form-label fw-semibold">About Page Main Description</label>
                            <textarea class="form-control @error('about_text') is-invalid @enderror" id="about_text" name="about_text" rows="8" placeholder="Tell your customers about your farm-to-table journey, organic certifications, quality standards, etc.">{{ old('about_text', $tenant->about_text) }}</textarea>
                            @error('about_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Policy Pages Settings -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header py-3">
                        <i class="fa-solid fa-shield-halved me-2 shopify-green"></i>
                        <h5 class="m-0 d-inline-block fw-bold">Store Policies</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="shipping_policy" class="form-label fw-semibold">Shipping & Delivery Policy</label>
                            <textarea class="form-control @error('shipping_policy') is-invalid @enderror" id="shipping_policy" name="shipping_policy" rows="5" placeholder="Details about delivery timeframes (e.g. 2 hours express), charges, regions covered, etc.">{{ old('shipping_policy', $tenant->shipping_policy) }}</textarea>
                            @error('shipping_policy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="return_policy" class="form-label fw-semibold">Return & Refund Policy</label>
                            <textarea class="form-control @error('return_policy') is-invalid @enderror" id="return_policy" name="return_policy" rows="5" placeholder="Information about returns guarantee (e.g. refund at door if quality isn't up to standard), processing time, etc.">{{ old('return_policy', $tenant->return_policy) }}</textarea>
                            @error('return_policy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="terms_of_service" class="form-label fw-semibold">Terms of Service</label>
                            <textarea class="form-control @error('terms_of_service') is-invalid @enderror" id="terms_of_service" name="terms_of_service" rows="5" placeholder="General rules, pricing updates, and legal usage conditions.">{{ old('terms_of_service', $tenant->terms_of_service) }}</textarea>
                            @error('terms_of_service')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Contact Details & Submit -->
            <div class="col-lg-4">
                <!-- Contact Info Settings -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header py-3 d-flex align-items-center">
                        <i class="fa-solid fa-envelope-open-text me-2 shopify-green"></i>
                        <h5 class="m-0 fw-bold">Contact Page Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="contact_email" class="form-label fw-semibold">Support Email Address</label>
                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email', $tenant->contact_email) }}" placeholder="e.g. support@yourstore.com">
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label fw-semibold">Support Phone Number</label>
                            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $tenant->contact_phone) }}" placeholder="e.g. +91 98765 43210">
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="contact_address" class="form-label fw-semibold">Physical Shop Address</label>
                            <textarea class="form-control @error('contact_address') is-invalid @enderror" id="contact_address" name="contact_address" rows="4" placeholder="Store address details...">{{ old('contact_address', $tenant->contact_address) }}</textarea>
                            @error('contact_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <button type="submit" class="btn btn-success bg-shopify-green w-100 py-2 fw-semibold">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
