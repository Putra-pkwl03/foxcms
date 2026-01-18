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
        Schema::create('guest_checkins', function (Blueprint $table) {
            $table->id();
            $table->string('room_number', 10);
            $table->string('guest_name', 100);
            $table->dateTime('checkin_time')->useCurrent();
            $table->dateTime('checkout_time')->nullable();
            $table->enum('status', ['checked_in', 'checked_out'])->default('checked_in');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_checkins');
    }
};
