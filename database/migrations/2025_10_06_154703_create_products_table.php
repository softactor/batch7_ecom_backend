<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_desc')->nullable();
            $table->decimal('price', 10);
            $table->enum('discount_type', ['fixed', 'percentage'])->nullable();
            $table->integer('discount')->nullable();
            $table->decimal('discount_price', 10)->nullable();
            $table->boolean('stock')->default(true);
            $table->string('image');
            $table->float('star')->nullable();
            $table->enum('remarks',['popular','featured','new','bestseller','trending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
