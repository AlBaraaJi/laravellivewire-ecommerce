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
            $table->string('name'); // Add name column
            $table->text('description'); // Add description column
            $table->decimal('price', 10, 2); // Add price column with precision and scale
            // $table->unsignedBigInteger('catagory_id');
            $table->timestamps();
            
            $table->foreign('catagory_id')->references('id')->on('catagories')->onDelete('cascade');
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
