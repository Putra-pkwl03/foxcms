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
        Schema::create('home_menus', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('menu_key')->unique();
            $blueprint->string('menu_name');
            $blueprint->string('menu_name_en')->nullable();
            $blueprint->string('icon_path')->nullable();
            $blueprint->string('action_type')->default('dialog'); // function, dialog, app
            $blueprint->string('action_value')->nullable();
            $blueprint->integer('sort_order')->default(0);
            $blueprint->boolean('is_active')->default(true);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_menus');
    }
};
