<?php

use App\Enums\StatusEnums;
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
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('sku')->nullable();
            $table->integer('price')->default(0);
            $table->integer('discount_price')->default(0);
            $table->integer('stock')->default(0);
            $table->integer('category_id')->nullable();
            $table->integer('brand')->nullable();
            $table->string('image')->nullable();
            $table->string('gallery')->nullable();
            $table->tinyText('status')->default(StatusEnums::ACTIVE);
            $table->timestamps();
            $table->softDeletes();
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
