<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeProductFilter($query, $request): void
    {
        if($request->filled('category_id')){
            $query->where('category_id',$request->category_id);
        }

        if($request->filled('brand_id')){
            $query->where('brand_id',$request->brand_id);
        }

        if($request->filled('remarks')){
            $query->where('remarks',$request->remarks);
        }

    }
}
