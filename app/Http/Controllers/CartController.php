<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Add to cart
    public function add(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $qty = max(1, (int) $request->input('quantity', 1));

        // Stock check
        $cart = session()->get('cart', []);
        $alreadyInCart = isset($cart[$slug]) ? $cart[$slug]['quantity'] : 0;
        $totalRequested = $alreadyInCart + $qty;

        if ($product->quantity <= 0) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is out of stock.',
                ], 422);
            }
            return redirect()->back()->with('error', 'This product is out of stock.');
        }

        if ($totalRequested > $product->quantity) {
            $available = $product->quantity - $alreadyInCart;
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$product->quantity} available in stock.",
                ], 422);
            }
            return redirect()->back()->with('error', "Only {$product->quantity} available in stock.");
        }

        if (isset($cart[$slug])) {
            $cart[$slug]['quantity'] += $qty;
        } else {
            $cart[$slug] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $qty,
                'image'    => $product->image,
            ];
        }

        session()->put('cart', $cart);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cartCount' => count(session('cart', [])),
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart');
    }

    // View cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Update quantity
    public function update(Request $request, $slug)
    {
        $cart = session()->get('cart');

        if (isset($cart[$slug])) {
            $product = Product::where('slug', $slug)->first();
            $newQty = max(1, (int) $request->quantity);

            if ($product && $newQty > $product->quantity) {
                return redirect()->back()
                    ->with('error', "{$product->name}: only {$product->quantity} available in stock.");
            }

            $cart[$slug]['quantity'] = $newQty;
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // Remove item
    public function remove($slug)
    {
        $cart = session()->get('cart');

        if (isset($cart[$slug])) {
            unset($cart[$slug]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}
