<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantParam = $request->route('tenant');

        if ($tenantParam) {
            // Find tenant by ID
            $tenant = Tenant::find($tenantParam);

            if (!$tenant) {
                // Alternatively try finding by slug/name matching
                $tenant = Tenant::where('name', 'like', str_replace('-', ' ', $tenantParam))->first();
            }

            if (!$tenant) {
                abort(404, 'Tenant storefront not found.');
            }

            // Share resolved tenant globally with all views
            view()->share('currentTenant', $tenant);
            
            // Set session/config for reference in scope or controllers
            session(['active_tenant_id' => $tenant->id]);

            // Set global route default for 'tenant' parameter so we don't need to specify it manually everywhere
            \Illuminate\Support\Facades\URL::defaults(['tenant' => $tenantParam]);

            // Forget the tenant parameter so it is not passed to the controller methods
            if ($request->route()) {
                $request->route()->forgetParameter('tenant');
            }
        }

        return $next($request);
    }
}
