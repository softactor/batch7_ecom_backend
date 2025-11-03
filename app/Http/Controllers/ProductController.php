<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSlider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::with('brand','category')->productFilter($request)->paginate(20);
        return $this->success($products);
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::with('brand','category')->where('slug',$slug)->first();
        if(!$product) return $this->error('Product not found',404);
        return $this->success($product);
    }

    public function productSliders(): JsonResponse
    {
        $sliders = ProductSlider::with('product')->get();
        return $this->success($sliders);
    }


}
