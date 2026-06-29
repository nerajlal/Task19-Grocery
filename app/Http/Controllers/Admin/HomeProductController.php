<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeProductController extends Controller
{
    public function index(Request $request)
    {
        $selectedProducts = HomeProduct::with('product.images')->orderBy('sort_order')->get()->filter(function($item) {
            return $item->product !== null;
        });
        
        $query = Product::with('images')->where('status', 'active')
            ->whereNotIn('id', $selectedProducts->pluck('product_id'));

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $allProducts = $query->paginate(10);

        if ($request->ajax()) {
            // Check which tab or search request it is
            if ($request->has('tab') && $request->tab === 'all') {
                return view('admin.settings.home_products.partials.all_products_table', compact('allProducts'))->render();
            }
        }

        return view('admin.settings.home_products.index', compact('selectedProducts', 'allProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:home_products,product_id',
        ]);

        $count = HomeProduct::count();
        if ($count >= 8) {
            return redirect()->back()->with('error', 'You can only select up to 8 products.');
        }

        HomeProduct::create([
            'product_id' => $request->product_id,
            'sort_order' => $count + 1,
            'tenant_id' => session('active_tenant_id') ?? (auth()->check() ? auth()->user()->tenant_id : null),
        ]);

        return redirect()->back()->with('success', 'Product added to Home Page.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:home_products,id',
        ]);

        foreach ($request->order as $index => $id) {
            HomeProduct::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $homeProduct = HomeProduct::findOrFail($id);
        $homeProduct->delete();

        return redirect()->back()->with('success', 'Product removed from Home Page.');
    }
}
