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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')          // This will create the user_id column and set it as a foreign key.
                ->constrained('users')       // It references the 'users' table (assuming 'users' is the name of the table).
                ->onDelete('cascade');       // When a user is deleted, their cart will also be deleted.
            $table->foreignId('product_id')       // This will create the product_id column and set it as a foreign key.
                ->constrained('products')    // It references the 'products' table (assuming 'products' is the name of the table).
                ->onDelete('cascade');       // When a product is deleted, its cart entries will also be deleted.
            $table->integer('quantity');          // This will store the quantity of the product in the cart.
            $table->timestamps();                 // Created at and updated at timestamps.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
