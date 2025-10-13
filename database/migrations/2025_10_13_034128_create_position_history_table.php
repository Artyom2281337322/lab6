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
        Schema::create('position_history', function (Blueprint $table) {
           $table->id('id_record');
            $table->foreignId('id_employee')->constrained('employees', 'id_employee');
            $table->foreignId('id_position')->constrained('positions', 'id_position');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_history');
    }
};
