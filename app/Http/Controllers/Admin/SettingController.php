<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantPaymentSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show domain settings view.
     */
    public function domainIndex()
    {
        $tenantId = auth()->user()->tenant_id ?? session('active_tenant_id') ?? 1;
        $tenant = Tenant::findOrFail($tenantId);

        return view('admin.settings.domain', compact('tenant'));
    }

    /**
     * Update domain settings.
     */
    public function domainUpdate(Request $request)
    {
        $tenantId = auth()->user()->tenant_id ?? session('active_tenant_id') ?? 1;
        $tenant = Tenant::findOrFail($tenantId);

        $request->validate([
            'domain' => 'nullable|string|max:255|unique:tenants,domain,' . $tenantId,
        ]);

        $tenant->update([
            'domain' => $request->domain,
        ]);

        return redirect()->back()->with('success', 'Domain settings updated successfully.');
    }

    /**
     * Show payment settings view.
     */
    public function paymentIndex()
    {
        $tenantId = auth()->user()->tenant_id ?? session('active_tenant_id') ?? 1;
        $paymentSetting = TenantPaymentSetting::firstOrCreate(['tenant_id' => $tenantId]);

        return view('admin.settings.payment', compact('paymentSetting'));
    }

    /**
     * Update payment settings.
     */
    public function paymentUpdate(Request $request)
    {
        $tenantId = auth()->user()->tenant_id ?? session('active_tenant_id') ?? 1;
        $paymentSetting = TenantPaymentSetting::firstOrCreate(['tenant_id' => $tenantId]);

        $request->validate([
            'cod_enabled' => 'nullable|boolean',
            'stripe_enabled' => 'nullable|boolean',
            'stripe_key' => 'nullable|required_if:stripe_enabled,1|string|max:255',
            'stripe_secret' => 'nullable|required_if:stripe_enabled,1|string|max:255',
            'razorpay_enabled' => 'nullable|boolean',
            'razorpay_key' => 'nullable|required_if:razorpay_enabled,1|string|max:255',
            'razorpay_secret' => 'nullable|required_if:razorpay_enabled,1|string|max:255',
            'phonepe_enabled' => 'nullable|boolean',
            'phonepe_merchant_id' => 'nullable|required_if:phonepe_enabled,1|string|max:255',
            'phonepe_salt_key' => 'nullable|required_if:phonepe_enabled,1|string|max:255',
            'phonepe_salt_index' => 'nullable|required_if:phonepe_enabled,1|string|max:255',
        ]);

        $paymentSetting->update([
            'cod_enabled' => $request->has('cod_enabled'),
            'stripe_enabled' => $request->has('stripe_enabled'),
            'stripe_key' => $request->stripe_key,
            'stripe_secret' => $request->stripe_secret,
            'razorpay_enabled' => $request->has('razorpay_enabled'),
            'razorpay_key' => $request->razorpay_key,
            'razorpay_secret' => $request->razorpay_secret,
            'phonepe_enabled' => $request->has('phonepe_enabled'),
            'phonepe_merchant_id' => $request->phonepe_merchant_id,
            'phonepe_salt_key' => $request->phonepe_salt_key,
            'phonepe_salt_index' => $request->phonepe_salt_index,
        ]);

        return redirect()->back()->with('success', 'Payment gateway settings updated successfully.');
    }
}
