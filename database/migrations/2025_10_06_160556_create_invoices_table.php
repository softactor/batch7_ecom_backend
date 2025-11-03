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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('invoice_no')->unique();
            $table->decimal('total',10);
            $table->decimal('vat',10)->nullable();
            $table->decimal('payable',10);
            $table->text('cust_details');
            $table->text('ship_details');
            $table->enum('status',['Pending','Confirmed','Cancelled','Processing','Completed'])->default('Pending');
            $table->enum('payment_status',['Unpaid','Paid'])->default('Unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
