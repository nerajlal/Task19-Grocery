<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $tenants = \App\Models\Tenant::with('admin')->get();
        
        $totalStores = \App\Models\Tenant::count();
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalCustomers = \App\Models\User::where('type', 'user')->count();
        
        $recentOrders = \App\Models\Order::latest()->take(5)->get();
        
        $planBreakdown = [
            'sprout' => \App\Models\Tenant::where('plan', 'sprout')->count(),
            'maison' => \App\Models\Tenant::where('plan', 'maison')->count(),
            'heritage' => \App\Models\Tenant::where('plan', 'heritage')->count(),
        ];

        return view('super_admin.dashboard', compact(
            'tenants', 
            'totalStores', 
            'totalOrders', 
            'totalRevenue', 
            'totalCustomers', 
            'recentOrders', 
            'planBreakdown'
        ));
    }

    public function createTenant()
    {
        return view('super_admin.create_tenant');
    }

    public function storeTenant(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'site_name' => 'required|string|max:255',
            'plan' => 'required|string|max:50',
            'theme' => 'required|string|max:50',
        ]);

        // Create Tenant with Plan and Theme
        $tenant = \App\Models\Tenant::create([
            'name' => $validated['site_name'],
            'plan' => $validated['plan'],
            'theme' => $validated['theme'],
        ]);

        // Create Tenant Admin User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => 'admin',
            'site_name' => $validated['site_name'],
            'tenant_id' => $tenant->id,
        ]);

        // Auto-seed initial template catalog for this manually provisioned tenant
        \App\Services\TenantCatalogSeeder::seedForTenant($tenant->id);

        return redirect()->route('super_admin.dashboard')->with('success', 'Tenant Admin and store catalog created successfully.');
    }

    public function tenants()
    {
        $tenants = \App\Models\Tenant::with('admin')->paginate(15);
        return view('super_admin.tenants', compact('tenants'));
    }

    public function orders()
    {
        $orders = \App\Models\Order::latest()->paginate(15);
        return view('super_admin.orders', compact('orders'));
    }

    public function customers()
    {
        $customers = \App\Models\User::where('type', 'user')->latest()->paginate(15);
        return view('super_admin.customers', compact('customers'));
    }

    public function plans()
    {
        $plans = [
            [
                'id' => 'sprout',
                'name' => 'Sprout (Starter)',
                'price' => 9.00,
                'billing' => 'month',
                'limit' => 'Up to 50 Products',
                'features' => ['Standard Checkout', 'Aura Luxe & Modern Minimal Themes', 'Basic Analytics', 'WhatsApp Support']
            ],
            [
                'id' => 'maison',
                'name' => 'Maison (Professional)',
                'price' => 29.00,
                'billing' => 'month',
                'limit' => 'Up to 250 Products',
                'features' => ['Custom Domain Routing', 'All Themes Enabled', 'Advanced Inventory Tracker', 'Priority Email Support']
            ],
            [
                'id' => 'heritage',
                'name' => 'Heritage (Enterprise)',
                'price' => 99.00,
                'billing' => 'month',
                'limit' => 'Unlimited Products',
                'features' => ['Dedicated Account Manager', 'Custom CSS Styling', 'Automated Daily Backups', '24/7 Phone & SLA Support']
            ]
        ];
        return view('super_admin.plans', compact('plans'));
    }

    public function status()
    {
        $dbConnected = false;
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Exception $e) {}

        $statusInfo = [
            'db_connection' => $dbConnected ? 'Connected' : 'Disconnected',
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'app_env' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'database_name' => config('database.connections.mysql.database'),
            'total_tenants' => \App\Models\Tenant::count(),
            'total_products' => \App\Models\Product::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_users' => \App\Models\User::count(),
        ];
        return view('super_admin.status', compact('statusInfo'));
    }
}
