<?php

use App\Models\Category;
use App\Models\Currency;
use App\Models\User;
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
            $table->string('title',200);
            $table->integer('quantity')->default(0);
            $table->string('headLine',300);
            $table->longText('description')->nullable();
            $table->boolean('published')->default(1);
            $table->decimal('price', 10,2)->default(0.0);
            $table->decimal('discount',  3,2)->default(0);
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->foreignIdFor(Category::class, 'category_id')->nullable();
            $table->foreignIdFor(Currency::class, 'currency_id')->nullable();
            $table->foreignIdFor(User::class,'deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_products');
    }
};
