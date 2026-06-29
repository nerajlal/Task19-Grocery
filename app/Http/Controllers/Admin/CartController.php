<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Fetch users who have items in their cart, with the cart items eagerly loaded
        $usersWithCarts = User::whereHas('cart')->with(['cart.product.images', 'cart.bundle'])->paginate(10);
        
        return view('admin.carts.index', compact('usersWithCarts'));
    }
}
