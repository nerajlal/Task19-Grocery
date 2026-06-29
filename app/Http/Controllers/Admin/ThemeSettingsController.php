<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ThemeSettingsController extends Controller
{
    /**
     * Show the theme selection settings page.
     */
    public function index()
    {
        $tenantId = auth()->user()->tenant_id ?? session('active_tenant_id') ?? 1;
        $tenant = Tenant::findOrFail($tenantId);

        // List of all supported themes in the system
        $themes = [
            [
                'id' => 'aura_luxe',
                'name' => 'Aura Luxe',
                'version' => 'Modern Luxury',
                'description' => 'Modern luxury layout with a clean premium feel, beautiful grid designs, and gold accents.',
                'preview_img' => '/Images/landing/v3-template.png',
                'preview_route' => 'v3.home',
            ],
            [
                'id' => 'velvet_dark',
                'name' => 'Velvet Dark',
                'version' => 'Dark Luxury',
                'description' => 'Sleek, immersive dark aesthetic tailored for high-end boutique brands and luxury vibes.',
                'preview_img' => '/Images/landing/v2-template.png',
                'preview_route' => 'velvet.home',
            ],
            [
                'id' => 'editorial_cream',
                'name' => 'Editorial Cream',
                'version' => 'Elegant Cream',
                'description' => 'Classic, editorial feel with cream background accents, sophisticated fonts, and clean lines.',
                'preview_img' => '/Images/landing/v4-template.png',
                'preview_route' => 'v4.home',
            ],
            [
                'id' => 'modern_minimal',
                'name' => 'Modern Minimal',
                'version' => 'Clean Minimal',
                'description' => 'Super clean, high-performance, and straightforward layout focused entirely on readability.',
                'preview_img' => '/Images/landing/v1-template.png',
                'preview_route' => 'v1.home',
            ],
        ];

        return view('admin.settings.theme', compact('tenant', 'themes'));
    }

    /**
     * Update the storefront theme.
     */
    public function update(Request $request)
    {
        $request->validate([
            'theme' => [
                'required',
                Rule::in(['aura_luxe', 'velvet_dark', 'editorial_cream', 'modern_minimal'])
            ]
        ]);

        $tenantId = auth()->user()->tenant_id ?? session('active_tenant_id') ?? 1;
        $tenant = Tenant::findOrFail($tenantId);
        
        $tenant->theme = $request->theme;
        $tenant->save();

        return redirect()->back()->with('success', 'Storefront theme updated successfully.');
    }
}
