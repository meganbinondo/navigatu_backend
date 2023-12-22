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
        Schema::create('appointment', function (Blueprint $table) {
            $table->id('appointment_no');
            $table->unsignedBigInteger('created_by')->nullable(); // This establishes the foreign key relationship
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('area');
            $table->string('event_name');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('event_date');
            $table->string('status')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
    }
};

