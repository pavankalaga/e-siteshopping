<?php

namespace App\Http\Controllers;

use App\Helpers\CartHelper;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Session; 
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class CartController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); 
        $cart = session()->get("cart.$userId", []); 
    
        return view('cart.index', compact('cart'));
    }
    

    public function add(Request $request)
    {
        $userId = auth()->id();
        $cart = session()->get("cart.$userId", []);
        $id = $request->id;
    
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('cart.index')->with('error', 'This product does not exist.');
        }
    
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
    
        session()->put("cart.$userId", $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }
    
    

    public function update(Request $request)
    {
        \Log::info('Update cart:', $request->all());
    
        $userId = auth()->id(); 
        $cart = session()->get("cart.$userId", []); 
    
        \Log::info('Current cart:', $cart);
    
        $id = $request->id;
    
        if (is_array($cart) && isset($cart[$id])) {
            $cart[$id]['quantity'] = (int)$request->quantity; 
            session()->put("cart.$userId", $cart); 
    
            \Log::info('Cart  updated:', session()->get("cart.$userId"));
    
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
        }
    
        return redirect()->route('cart.index')->with('error', 'Item not found in cart!');
    }
    
    
   public function remove(Request $request)
     {
    $userId = auth()->id(); 
    $cart = session()->get("cart.$userId", []); 
    $id = $request->id;

    if (isset($cart[$id])) {
        unset($cart[$id]); 
        session()->put("cart.$userId", $cart); 
        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    return redirect()->route('cart.index')->with('error', 'Item not found in cart!');
     }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }


   

    public function place_order(){
        return view('cart.checkout');
    }
    public function process(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zipcode' => 'required|string|max:6',
        ]);
    
        $cart = CartHelper::getCart();
        $user_id = Auth::id();
        $updatedCart = $cart;
    
        DB::beginTransaction();
        try {
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
    
                if (!$product) {
                    unset($updatedCart[$productId]);
                    continue; 
                }
    
                $amountPaid = $product->price * $item['quantity'];
    
                Order::create([
                    'user_id' => $user_id,
                    'product_id' => $productId,
                    'amount_paid' => $amountPaid,
                    'address' => $request->address,
                    'zipcode' => $request->zipcode
                ]);
            }
    
            CartHelper::updateCart($updatedCart);
            CartHelper::clearCart();
            DB::commit();
            return redirect()->route('cart.index')->with('success', 'Ordered successfully! Thank you.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    

    public function card_view(){
        $products=Product::orderBy('created_at', 'desc')->get();
        return view('Products.card_view',compact('products'));
    }
}
