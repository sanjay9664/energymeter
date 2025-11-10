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
        Schema::create('recharge_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->nullable(); // agar site wise save karna ho
            $table->decimal('recharge_amount', 12, 2)->nullable();

            $table->decimal('mains_fixed_charge', 12, 2)->nullable();
            $table->decimal('mains_unit_charge', 12, 4)->nullable();
            $table->decimal('mains_sanction_load', 8, 3)->nullable();

            $table->decimal('dg_fixed_charge', 12, 2)->nullable();
            $table->decimal('dg_unit_charge', 12, 4)->nullable();
            $table->decimal('dg_sanction_load', 8, 3)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recharge_settings');
    }
};
