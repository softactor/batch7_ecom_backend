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
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('password')->after('email')->nullable();
            $table->enum('type',['Admin','Customer'])->default('Customer')->after('password');
            $table->integer('otp')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->change();
            $table->dropColumn('password');
            $table->dropColumn('type',['Admin','Customer']);
            $table->integer('otp')->change();
        });
    }
};
