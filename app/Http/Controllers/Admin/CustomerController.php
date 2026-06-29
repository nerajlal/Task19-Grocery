<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('type', 'user')
            ->with('defaultAddress')
            ->withCount('orders')
            ->withSum('orders as total_spent', 'total_amount');

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by Status (Verified/Unverified)
        if ($request->has('status')) {
            if ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Sort
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $customers = $query->paginate(10);

        return view('admin.customers', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::with(['defaultAddress', 'orders' => function($query) {
            $query->latest();
        }])
        ->withCount('orders')
        ->withSum('orders as total_spent', 'total_amount')
        ->findOrFail($id);
        
        return view('admin.customers.show', compact('customer'));
    }
}
