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
        Schema::create('hotel_infos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('title_en', 150)->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->string('icon_path')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('show_description')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_infos');
    }
};
