<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $query = Discount::query();

        // Search
        if ($request->filled('search')) {
            $query->where('code', 'LIKE', '%' . $request->search . '%');
        }

        // Status Filter
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('status', 'active')
                          ->where('starts_at', '<=', now())
                          ->where(function($q) {
                              $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
                          });
                    break;
                case 'expired':
                     $query->where('status', 'active')
                           ->whereNotNull('ends_at')
                           ->where('ends_at', '<', now());
                    break;
                case 'inactive':
                    $query->where('status', '!=', 'active');
                    break;
            }
        }

        // Type Filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'code_asc':
                    $query->orderBy('code', 'asc');
                    break;
                case 'code_desc':
                    $query->orderBy('code', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $discounts = $query->paginate(10);
        
        if ($request->ajax()) {
            return view('admin.discounts.partials.table', compact('discounts'))->render();
        }

        $total = Discount::count();
        $active = Discount::where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where(function($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })->count();
        $expired = Discount::where('status', 'active')->whereNotNull('ends_at')->where('ends_at', '<', now())->count();
        $inactive = Discount::where('status', '!=', 'active')->count();
        
        return view('admin.discounts.index', compact('discounts', 'total', 'active', 'expired', 'inactive'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->get();
        return view('admin.discounts.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:discounts,code|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'status' => 'required|in:active,draft,archived',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $discount = Discount::create($request->only([
            'code', 'type', 'value', 'status', 'starts_at', 'ends_at', 'usage_limit'
        ]));

        if ($request->has('products')) {
            $discount->products()->attach($request->products);
        }

        return redirect()->route('admin.discounts')->with('success', 'Discount created successfully.');
    }

    public function edit($id)
    {
        $discount = Discount::with('products')->findOrFail($id);
        $products = Product::where('status', 'active')->get();
        return view('admin.discounts.edit', compact('discount', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:discounts,code,' . $id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'status' => 'required|in:active,draft,archived',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $discount = Discount::findOrFail($id);
        $discount->update($request->only([
            'code', 'type', 'value', 'status', 'starts_at', 'ends_at', 'usage_limit'
        ]));

        if ($request->has('products')) {
            $discount->products()->sync($request->products);
        } else {
            $discount->products()->detach();
        }

        return redirect()->route('admin.discounts')->with('success', 'Discount updated successfully.');
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return redirect()->route('admin.discounts')->with('success', 'Discount deleted successfully.');
    }
}
