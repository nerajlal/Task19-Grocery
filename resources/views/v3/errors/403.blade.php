@extends('v3.layouts.app')

@section('title', 'Forbidden')

@push('styles')
<style>
    .error-section {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 80px 20px;
        background: var(--bg-light);
    }
    .error-content {
        max-width: 600px;
    }
    .error-code {
        font-family: 'Playfair Display', serif;
        font-size: 150px;
        font-weight: 900;
        line-height: 1;
        color: transparent;
        -webkit-text-stroke: 2px var(--gold);
        opacity: 0.5;
        margin-bottom: -20px;
    }
    .error-title {
        font-family: 'Playfair Display', serif;
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--black);
    }
    .error-text {
        color: var(--text-light);
        margin-bottom: 30px;
        font-size: 16px;
        line-height: 1.6;
    }
    .error-btn {
        display: inline-block;
        background: var(--black);
        color: var(--white);
        padding: 15px 40px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }
    .error-btn:hover {
        background: var(--gold);
        transform: translateY(-3px);
    }
</style>
@endpush

@section('content')
    <div class="error-section">
        <div class="error-content">
            <div class="error-code">403</div>
            <h1 class="error-title">Forbidden</h1>
            <p class="error-text">You do not have permission to access this page.</p>
            <a href="{{ url('/') }}" class="error-btn">Return to Home</a>
        </div>
    </div>
@endsection
