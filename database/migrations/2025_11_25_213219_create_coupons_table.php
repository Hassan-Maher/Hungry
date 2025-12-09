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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('type' , ['precentage' , 'fixed']);
            $table->decimal('discount_value');
            $table->integer('max_uses')->nullable();
            $table->integer('uses_count')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->enum('status' , ['active' , 'in_active'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
