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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete();
            $table->decimal('coupon_discount' , 8,2)->default(0);
            $table->decimal('taxes' , 8,2)->default(0);
            $table->decimal('delivery_fees' , 8 ,2)->default(0);
            $table->decimal('Final_price', 10 ,2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
