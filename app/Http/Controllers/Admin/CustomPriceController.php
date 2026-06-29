<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPrice;
use Illuminate\Http\Request;

class CustomPriceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
        ]);

        $tenantId = session('active_tenant_id') ?? request()->route('tenant') ?? 1;

        // Check if custom price already exists for this customer and product
        CustomPrice::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'tenant_id' => $tenantId,
            ],
            [
                'price' => $request->price,
            ]
        );

        return redirect()->route('admin.discounts', ['tab' => 'custom-prices'])->with('success', 'Custom pricing created successfully.');
    }

    public function destroy($id)
    {
        $customPrice = CustomPrice::findOrFail($id);
        $customPrice->delete();

        return redirect()->route('admin.discounts', ['tab' => 'custom-prices'])->with('success', 'Custom pricing deleted successfully.');
    }
}
