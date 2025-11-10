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
        Schema::table('devices', function (Blueprint $table) {
            // adjust type/length as needed (string(100) for shorter, text for long)
            $table->string('alternate_device_id')->nullable()->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            // drop unique index first if your DB requires explicit name
            $table->dropUnique(['alternate_device_id']);
            $table->dropColumn('alternate_device_id');
        });
    }
}

};
