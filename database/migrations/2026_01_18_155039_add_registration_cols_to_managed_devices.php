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
        Schema::table('managed_devices', function (Blueprint $table) {
            $table->string('registration_code', 20)->nullable()->after('device_id');
            $table->string('ip_address', 45)->nullable()->after('last_seen');
            $table->string('status_online', 20)->default('offline')->after('ip_address');
            $table->text('notes')->nullable()->after('status_online');
            $table->timestamp('registered_at')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('managed_devices', function (Blueprint $table) {
            $table->dropColumn(['registration_code', 'ip_address', 'status_online', 'notes', 'registered_at']);
        });
    }
};
