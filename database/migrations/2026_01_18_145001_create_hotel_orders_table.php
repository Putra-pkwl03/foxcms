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
        Schema::create('hotel_orders', function (Blueprint $table) {
            $table->id();
            $table->string('room_number', 20)->nullable();
            $table->string('guest_name', 100)->nullable();
            $table->text('items')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Delivered', 'Cancelled'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_orders');
    }
};
