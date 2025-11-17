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
    Schema::table('recharge_settings', function (Blueprint $table) {
        $table->decimal('kwh', 10, 2)->nullable()->after('dg_sanction_load');
    });
}

public function down()
{
    Schema::table('recharge_settings', function (Blueprint $table) {
        $table->dropColumn('kwh');
    });
}

};
