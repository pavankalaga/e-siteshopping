<?php 
namespace App\Helpers;

class CartHelper
{
    public static function getCart()
    {
        $userId = auth()->id();
        return session()->get("cart.$userId", []);
    }

    public static function updateCart(array $updatedCart)
    {
        $userId = auth()->id();
        session()->put("cart.$userId", $updatedCart);
    }

    public static function clearCart()
    {
        $userId = auth()->id();
        session()->forget("cart.$userId");
    }
}