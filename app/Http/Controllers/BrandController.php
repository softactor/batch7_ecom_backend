<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(): JsonResponse
    {
        $brands = Brand::select('id','name','image')->get();
        return $this->success($brands);
    }
}
