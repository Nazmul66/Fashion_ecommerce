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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('company_name')->nullable();
            $table->text('address');
            $table->text('address_optional')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('state');
            $table->string('order_note')->nullable();
            $table->string('postcode');
            $table->integer('discount_price');
            $table->integer('shipping_price');
            $table->integer('total_cart_price');
            $table->string('payment_method');
            $table->integer('is_delete')->default(1)->comment('1=active, 0=delete');
            $table->integer('status')->default(1)->comment('0=pending, 1=success, 2=cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
