<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Http\Requests\RemoveCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{

    public function index(): JsonResponse
    {
        $carts = Cart::with('product')->where('user_id',auth()->id())->get();
        return $this->success($carts);
    }
    public function addToCart(AddCartRequest $request): JsonResponse
    {
        $user = auth()->user();
        if(Cart::whereUserId($user->id)->whereProductId($request->id)->exists())
            return $this->error(['Product already added to cart'],400);

        $product = Product::findOrFail($request->product_id);
        // $productDetails = ProductDetails::whereProductId($product->id)->get();

        // $availableSizes = $productDetails->pluck('size')->unique()->values();
        // $availableColors = $productDetails->pluck('color')->unique()->values();

        // if($availableSizes->isNotEmpty()){
        //     if(!$request->filled('size')){
        //         return $this->error(['Size is required'],400);
        //     }
        //     if(!$availableSizes->contains($request->size)){
        //         return $this->error(['Size not available'],400);
        //     }
        // }

        // if($availableColors->isNotEmpty()){
        //     if(!$request->filled('color')){
        //         return $this->error(['Color is required'],400);
        //     }
        //     if(!$availableColors->contains($request->color)){
        //         return $this->error(['Color not available'],400);
        //     }
        // }

        // if(!$availableSizes->isNotEmpty() && !$availableColors->isNotEmpty()){
        //     if(!ProductDetails::whereProductId($product->id)
        //         ->where('color',$request->color)
        //         ->where('size',$request->size)
        //         ->exists())
        //         return $this->error(['Color and size not available'],400);
        // }


        if($product->discount && $product->discount > 0){
            $price = $product->discount_price;
        }else{
            $price = $product->price;
        }

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $price,
            // 'color' => $availableColors->isNotEmpty() ? $request->color : null,
            // 'size' => $availableSizes->isNotEmpty() ? $request->size : null,
        ]);

        return $this->success(null,['Product added to cart']);
    }


    public function removeToCart(RemoveCartRequest $request): JsonResponse
    {
        $user = auth()->user();
        if(!$cart = Cart::whereId($request->cart_id)->whereUserId($user->id)->first())
            return $this->error(['Product not in your cart'],400);

        $cart->delete();

        return $this->success(null,['Product removed from cart']);
    }

    public function flashCart(): JsonResponse
    {
        Cart::whereUserId(auth()->id())->delete();
        return $this->success(null,['Cart cleared']);
    }
}
