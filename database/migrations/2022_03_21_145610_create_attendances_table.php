<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('checkin_time');
            $table->time('lunch_time')->nullable();
            $table->time('lunch_end_time')->nullable();
            $table->time('checkout_time')->nullable();
            $table->enum('day',['lunes',
                                'martes',
                                'miercoles',
                                'jueves',
                                'viernes',
                                'sabado',
                                'domingo']);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
