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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['catagory_id']); // Remove the foreign key constraint
            $table->dropColumn('catagory_id');   // Remove the column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('catagory_id')->nullable(); // Re-add the column as nullable
            $table->foreign('catagory_id')->references('id')->on('catagories')->onDelete('cascade');
        });
    }
};
