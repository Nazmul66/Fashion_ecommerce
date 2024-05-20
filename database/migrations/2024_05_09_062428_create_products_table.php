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
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('quantity');
            $table->string('sku_code')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('subCategory_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->text('tags')->nullable();
            $table->string('unit')->nullable();
            $table->integer('purchase_price')->default(0);
            $table->integer('selling_price')->default(0);
            $table->integer('discount_price')->default(0)->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->text('additional_information')->nullable();
            $table->text('shipping_returns')->nullable();
            $table->text('is_featured')->default(1)->nullable();
            $table->text('is_trendy')->default(1)->nullable();
            $table->text('is_promotion')->default(1)->nullable();
            $table->text('todays_deal')->default(1)->nullable();
            $table->integer('admin_id');
            $table->integer('status')->default(1)->comment('1=active, 0=inactive');
            $table->integer('is_delete')->default(0)->comment('1=delete, 0=active');
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
