<?php

use App\Enums\FieldWorkEnum;
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
        Schema::create('field_works', function (Blueprint $table) {
            $table->id();
            $table->enum('type',array_column(FieldWorkEnum::cases(),'value'));
            $table->foreignId('authorization_id')->constrained('authorizations');
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
        Schema::dropIfExists('field_works');
    }
};
