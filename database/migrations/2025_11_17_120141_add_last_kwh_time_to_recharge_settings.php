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
        Schema::table('recharge_settings', function (Blueprint $table) {
            $table->dateTime('last_kwh_time')->nullable()->after('kwh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recharge_settings', function (Blueprint $table) {
            $table->dropColumn('last_kwh_time');
        });
    }
};
