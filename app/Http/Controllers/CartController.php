<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Traits\httpResponses;

class CartController extends Controller
{
    use httpResponses;

    public function listCartItems(Request $request)
    {
        $token = $request->input('data.token');
        $userId = Auth::id();

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', $userId)->get();
        } elseif ($token) {
          
            $cartItems = Cart::where('token', $token)->get();
        } else {
            return $this->error($cartItems,'Invalid request',400);
        }

        $response = $cartItems->map(function ($cartItem) {
        return [
                'id' => $cartItem->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'discount' => $cartItem->discount,
                'tax' => $cartItem->tax,
                'user_id' => $cartItem->user_id,
                'name' => $cartItem->product->name,
                'slug' => $cartItem->product->slug,
                'productMaxQuantity' => $cartItem->product->productMaxQuantity,
                'mrp' => $cartItem->product->mrp,
                'images' => $cartItem->product->images, // Adjust this based on your product image structure
            ];
        });

        return $this->success($response,'',200);
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('data.product_id');
        $quantity = $request->input('data.quantity');
        $price = $request->input('data.price');
        $discount = $request->input('data.discount');
        $tax = $request->input('data.tax');
        $token = $request->input('data.token');

        // Check if the user is logged in or is a guest
        if (Auth::check()) {
            $userId = Auth::id();
            $cart = Cart::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'discount' => $discount,
                'tax' => $tax,
                'user_id' => $userId
            ]);
        } else {
            $cart = Cart::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'discount' => $discount,
                'tax' => $tax,
                'token' => $token
            ]);
        }
        return $this->success($cart,'Item added to cart',200);
    }

    public function updateCartItem(Request $request)
    {
        $quantity = $request->input('data.quantity');
        $price = $request->input('data.price');
        $discount = $request->input('data.discount');
        $tax = $request->input('data.tax');
        $id = $request->input('data.id');

        $cart = Cart::findOrFail($id);

        // Update the cart item
        $cart->update([
            'quantity' => $quantity,
            'price' => $price,
            'discount' => $discount,
            'tax' => $tax
        ]);

        return $this->success($cart,'Cart item updated',200);
    }

    public function removeCartItem(Request $request)
    {
        try {
            $token = $request->input('data.token');
            $userId = Auth::id();
            $cartId = $request->input('data.id');
           
            if (Auth::check()) {
                $cart = Cart::where('id', $cartId)
                    ->where('user_id', $userId)
                    ->first();

                if ($cart) {
                    $cart->delete();
                    return $this->success('','Cart item removed successfully',200);
                } else {
                    return $this->error('','Cart item not found or does not belong to the user',200);                   
                }
            } elseif ($token) {
               
                $cart = Cart::where('id', $cartId)
                    ->where('token', $token)
                    ->first();

                if ($cart) {
                    $cart->delete();
                    return $this->success('','Cart item removed successfully',200);
                } else {
                    return $this->error('','Cart item not found or does not belong to the user',200);     
                }
            } else {
                return $this->error('','Invalid request',400);
            }
        } catch (\Exception $e) {
          
            return new CategoryResource(null);
        }
        
    }
}
