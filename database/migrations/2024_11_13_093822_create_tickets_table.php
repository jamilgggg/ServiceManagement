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
        Schema::create('sp_ticket', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->integer('priority');
            $table->string('ticket_number');
            $table->integer('type');
            $table->integer('reported_by');
            $table->integer('acknowledged_by');
            $table->dateTime('acknowledgedby_datetime');
            $table->integer('technician_by');
            $table->string('client_contactnum');
            $table->string('client_email');
            $table->integer('fk_mif');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_ticket');
        Schema::dropIfExists('tickets');
    }
};
