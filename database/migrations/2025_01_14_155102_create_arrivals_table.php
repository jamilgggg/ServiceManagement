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
        Schema::create('sp_arrival', function (Blueprint $table) {
            $table->id();
            $table->date('date_started');
            $table->time('time_started');
            $table->date('date_finished');
            $table->time('time_finished');
            $table->integer('diagnostics');
            $table->integer('work_done');
            $table->integer('machine_status');
            $table->integer('cartridge_brand');
            $table->integer('cartridge_model');
            $table->integer('sp_ticket_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_arrival');
    }
};
