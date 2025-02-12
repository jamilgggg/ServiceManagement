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
            $table->dateTime('dueDate');
            $table->integer('ownership')->default(1);
            $table->integer('request')->default(1);
            $table->string('requestorName');
            $table->integer('priority')->default(1);
            $table->string('ticket_number')->nullable();
            $table->integer('type')->nullable();
            $table->integer('reported_by')->nullable();
            $table->integer('acknowledged_by')->nullable();
            $table->dateTime('acknowledgedby_datetime')->nullable();
            $table->integer('technician_by')->nullable();
            $table->string('client_contactnum');
            $table->string('client_email')->nullable();//no frontend
            $table->integer('fk_mif')->nullable();
            $table->integer('fk_branch')->nullable();
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
