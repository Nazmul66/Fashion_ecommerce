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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('meta_title');
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->integer('status')->default(1)->comment('1=active, 0=inactive');
            $table->integer('is_delete')->default(0)->comment('1=active, 0=delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
