<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('currencies', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->string('name'); // Currency name (e.g., US Dollar)
        $table->string('code', 3); // Currency code (e.g., USD)
        $table->string('sign', 3); // Currency sign (e.g., $)
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
