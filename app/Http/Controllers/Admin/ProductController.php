<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Attribute;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['variants', 'images']);

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Type Filter
        if ($request->filled('type')) {
             $query->where('type', $request->type);
        }

        // Vendor Filter
        if ($request->filled('vendor')) {
             $query->where('vendor', $request->vendor);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(10);

        if ($request->ajax()) {
            return view('admin.products.partials.table', compact('products'))->render();
        }
        
        // Stats
        $total = Product::count();
        $active = Product::where('status', 'active')->count();
        $draft = Product::where('status', 'draft')->count();
        $archived = Product::where('status', 'archived')->count();

        // Unique Types and Vendors for Filters
        $types = Product::distinct()->whereNotNull('type')->pluck('type');
        $vendors = Product::distinct()->whereNotNull('vendor')->pluck('vendor');

        return view('admin.products.index', compact('products', 'total', 'active', 'draft', 'archived', 'types', 'vendors'));
    }

    public function create()
    {
        $collections = Collection::all();
        $families = Attribute::where('type', 'family')->get();
        $notes = Attribute::where('type', 'note')->get();
        return view('admin.products.create', compact('collections', 'families', 'notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:active,draft',
            'min_order_qty' => 'nullable|integer|min:1',
            'max_order_qty' => 'nullable|integer|min:1|gte:min_order_qty',
            'variants' => 'array',
            'media.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $product = Product::create($request->only([
            'title', 'description', 'status', 'type', 'vendor', 
            'collection_id', 'gender', 'olfactory_family', 
            'intensity', 'oil_concentration', 'notes_top', 'notes_heart', 'notes_base',
            'min_order_qty', 'max_order_qty'
        ]));

        // Handle Variants
        if ($request->has('variant_data')) {
            foreach ($request->variant_data as $size => $data) {
                if (isset($data['enabled'])) {
                    $product->variants()->create([
                        'size' => $size,
                        'stock' => $data['stock'] ?? 0,
                        'price' => $data['price'],
                        'compare_at_price' => $data['compare_at_price'],
                    ]);
                }
            }
        }

        // Handle Media Uploads
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'type' => 'image', // simplified for now
                    'order' => 0
                ]);
            }
        }
        
        return redirect()->route('admin.products')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::with(['variants', 'images' => function($query) {
            $query->orderBy('order', 'asc');
        }])->findOrFail($id);
        $collections = Collection::all();
        $families = Attribute::where('type', 'family')->get();
        $notes = Attribute::where('type', 'note')->get();
        return view('admin.products.edit', compact('product', 'collections', 'families', 'notes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
             'media.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
             'min_order_qty' => 'nullable|integer|min:1',
             'max_order_qty' => 'nullable|integer|min:1|gte:min_order_qty',
        ]);

        $product = Product::findOrFail($id);
        
        // Max 5 Images Validation
        $currentCount = $product->images()->count();
        $deletedCount = $request->has('deleted_images') ? count($request->deleted_images) : 0;
        $newCount = $request->hasFile('media') ? count($request->file('media')) : 0;
        
        if (($currentCount - $deletedCount + $newCount) > 5) {
            return back()->withInput()->withErrors(['media' => "You can only have a maximum of 5 images. You currently have $currentCount, are deleting $deletedCount, and trying to add $newCount."]);
        }
        
        $product->update($request->only([
            'title', 'description', 'status', 'type', 'vendor', 
            'collection_id', 'gender', 'olfactory_family', 
            'intensity', 'oil_concentration', 'notes_top', 'notes_heart', 'notes_base',
            'min_order_qty', 'max_order_qty'
        ]));

        // Sync Variants
        if ($request->has('variant_data')) {
            $currentVariantIds = [];
            foreach ($request->variant_data as $size => $data) {
                if (isset($data['enabled'])) {
                    $variant = $product->variants()->updateOrCreate(
                        ['size' => $size],
                        [
                            'stock' => $data['stock'] ?? 0,
                            'price' => $data['price'],
                            'compare_at_price' => $data['compare_at_price'],
                        ]
                    );
                    $currentVariantIds[] = $variant->id;
                }
            }
            // Remove variants that were unchecked
            $product->variants()->whereNotIn('id', $currentVariantIds)->delete();
        }

        // Handle Image Deletion
        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    if (Storage::disk('public')->exists($image->path)) {
                        Storage::disk('public')->delete($image->path);
                    }
                    $image->delete();
                }
            }
        }

        // Handle Scan/Reorder Existing Images
        if ($request->has('media_order')) {
            foreach ($request->media_order as $index => $imageId) {
                $product->images()->where('id', $imageId)->update(['order' => $index]);
            }
        }

        // Handle Media Uploads
        if ($request->hasFile('media')) {
            $startOrder = $product->images()->max('order') + 1; // Start after existing
            foreach ($request->file('media') as $index => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'type' => 'image',
                    'order' => $startOrder + $index
                ]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // Delete images from storage
        foreach($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }

    public function getVariants($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        return response()->json($product->variants);
    }
}
