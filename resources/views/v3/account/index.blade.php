

@extends('v3.layouts.app')

@push('styles')
<style>
    .account-container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
    .account-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 30px; }
    
    /* Card Styles */
    .account-card { background: var(--white); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; height: 100%; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
    .card-header { padding: 20px; border-bottom: 1px solid var(--border); font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: var(--black); }
    .card-body { padding: 30px; }
    
    /* Profile Section */
    .profile-avatar { width: 80px; height: 80px; background: var(--black); color: var(--gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; margin: 0 auto 15px; }
    .profile-name { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; margin-bottom: 5px; color: var(--black); }
    .profile-email { color: var(--text-light); font-size: 14px; margin-bottom: 25px; }
    .logout-btn { width: 100%; padding: 12px; border: 1px solid #dc3545; color: #dc3545; background: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
    .logout-btn:hover { background: #dc3545; color: white; }

    /* Form Styles */
    .form-section-title { font-size: 12px; text-transform: uppercase; color: var(--text-light); font-weight: 700; letter-spacing: 1px; margin-bottom: 20px; display: block; }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--text); margin-bottom: 8px; letter-spacing: 0.5px; }
    .form-input { width: 100%; padding: 12px 15px; border: 1px solid var(--border); border-radius: 6px; font-size: 14px; color: var(--black); outline: none; transition: border-color 0.3s; font-family: 'Montserrat', sans-serif; }
    .form-input:focus { border-color: var(--black); }
    
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    
    .save-btn { background: var(--black); color: var(--white); border: none; padding: 14px 30px; border-radius: 6px; font-weight: 600; text-transform: uppercase; font-size: 13px; cursor: pointer; letter-spacing: 1px; transition: background 0.3s; margin-top: 10px; }
    .save-btn:hover { background: #333; }

    .alert-success { background: rgba(40, 167, 69, 0.1); color: var(--success); padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border: 1px solid rgba(40, 167, 69, 0.2); }

    @media (max-width: 768px) {
        .account-grid { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; gap: 0; }
    }
</style>
@endpush

@section('content')
<div class="account-container">
    <div class="account-grid">
        
        <!-- User Profile & Logout -->
        <div class="account-card">
            <div class="card-body text-center">
                 @php
                    $initials = collect(explode(' ', $user->name))->map(fn($s) => strtoupper(substr($s, 0, 1)))->take(2)->implode('');
                 @endphp
                 <div class="profile-avatar">{{ $initials }}</div>
                <h4 class="profile-name">{{ $user->name }}</h4>
                <p class="profile-email">{{ $user->email }}</p>
                
                <a href="{{ route('account.orders') }}" class="logout-btn" style="margin-bottom: 15px; color: var(--black); border-color: var(--black);">
                    <i class="fas fa-box-open"></i> My Orders
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Address Management -->
        <div class="account-card">
            <div class="card-header">
                Address Details
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert-success">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('account.address.update') }}" method="POST">
                    @csrf
                    <span class="form-section-title">Shipping Address</span>
                    
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone', $address->phone ?? '') }}" required placeholder="Enter your phone number">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Address Line 1</label>
                        <input type="text" name="address_line1" class="form-input" value="{{ old('address_line1', $address->address_line1 ?? '') }}" required placeholder="Street address, P.O. box">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Address Line 2 (Optional)</label>
                        <input type="text" name="address_line2" class="form-input" value="{{ old('address_line2', $address->address_line2 ?? '') }}" placeholder="Apartment, suite, unit, etc.">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-input" value="{{ old('city', $address->city ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">State</label>
                            <select name="state" class="form-input" required>
                                <option value="">Select State</option>
                                @foreach(['Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 'Kerala', 'Ladakh', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'] as $stateOption)
                                    <option value="{{ $stateOption }}" {{ (old('state', $address->state ?? '') == $stateOption) ? 'selected' : '' }}>{{ $stateOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" name="zip" class="form-input" value="{{ old('zip', $address->zip ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-input" value="India" readonly style="background-color: #f8f9fa;">
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <button type="submit" class="save-btn">Save Address</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
