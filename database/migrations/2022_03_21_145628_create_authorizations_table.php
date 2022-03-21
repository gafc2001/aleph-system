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
        Schema::create('authorizations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->date('date');
            $table->time('estimated_start_time');
            $table->time('estimated_end_time');
            $table->time('real_start_time');
            $table->time('real_end_time');
            $table->text('comments');
            $table->enum('reference',['extra_hours','compesations','field_works','permissions']);
            $table->boolean('was_accepted')->nullable();
            $table->foreignId('authorized_by')->constrained('users');
            $table->foreignId('employee_id')->constrained('users');
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
        Schema::dropIfExists('authorizations');
    }
};
