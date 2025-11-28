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
        Schema::create('recharges', function (Blueprint $table) {
            // Primary key - ye automatically 'id' column banata hai
            $table->id();
            
            // Foreign key
            $table->unsignedBigInteger('site_id');
            
            // Unique recharge identifier (primary key nahi)
            $table->string('recharge_id')->unique();
            
            // Amount
            $table->decimal('recharge_amount', 10, 2);
            
            // Timestamps
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            
            // Indexes
            $table->index('site_id');
            $table->index('recharge_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recharges');
    }
};