<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenantVideo;
use Illuminate\Http\Request;

use App\Models\Collection;

class TenantVideoController extends Controller
{
    /**
     * Show the storefront videos settings page.
     */
    public function index()
    {
        $tenantId = auth()->user()->tenant_id ?? session('active_tenant_id') ?? 1;
        $videoSetting = TenantVideo::firstOrCreate(['tenant_id' => $tenantId]);
        $collections = Collection::where('status', 1)->orderBy('name', 'asc')->get();

        return view('admin.settings.videos.index', compact('videoSetting', 'collections'));
    }

    /**
     * Update the storefront video URLs.
     */
    public function update(Request $request)
    {
        $tenantId = auth()->user()->tenant_id ?? session('active_tenant_id') ?? 1;
        $videoSetting = TenantVideo::firstOrCreate(['tenant_id' => $tenantId]);

        $validated = $request->validate([
            'video1_url' => 'nullable|string|max:500',
            'video1_collection_id' => 'nullable|exists:collections,id',
            'video2_url' => 'nullable|string|max:500',
            'video2_collection_id' => 'nullable|exists:collections,id',
            'video3_url' => 'nullable|string|max:500',
            'video3_collection_id' => 'nullable|exists:collections,id',
            'video4_url' => 'nullable|string|max:500',
            'video4_collection_id' => 'nullable|exists:collections,id',
            'video5_url' => 'nullable|string|max:500',
            'video5_collection_id' => 'nullable|exists:collections,id',
        ]);

        $videoSetting->update($validated);

        return redirect()->back()->with('success', 'Showcase videos and collections updated successfully.');
    }
}
