<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishListRequest;
use App\Models\ProductWishList;
use Illuminate\Http\JsonResponse;

class UserProductController extends Controller
{
    public function userWishList(): JsonResponse
    {
        $wishList = ProductWishList::with('product')->whereUserId(auth()->id())->get();
        return $this->success($wishList);
    }
    public function addWishList(WishListRequest $request): JsonResponse
    {
        $user = auth()->user();
        if(ProductWishList::where('user_id',$user->id)->where('product_id',$request->product_id)->exists())
            return $this->error(['Product already added to wishlist'],400);

        ProductWishList::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id
        ]);
        return $this->success(null,['Product added to wishlist']);
    }

    public function removeProductFromWishList(WishListRequest $request): JsonResponse
    {
        $user = auth()->user();
        $productWishList = ProductWishList::where('user_id',$user->id)
            ->where('product_id',$request->product_id)
            ->first();

        if(!$productWishList)
            return $this->error(['Product not in your wishlist'],400);

        $productWishList->delete();

        return $this->success(null,['Product removed from your wishlist']);
    }
}
