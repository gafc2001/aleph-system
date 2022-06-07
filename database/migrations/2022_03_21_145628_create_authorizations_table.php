<?php

use App\Enums\AuthorizationStateEnum;
use App\Enums\PermissionEnum;
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
            $table->time('real_start_time')->nullable();
            $table->time('real_end_time')->nullable();
            $table->text('comments')->nullable();
            $table->enum('reference',array_column(PermissionEnum::cases(),'value'));
            $table->enum('state',array_column(AuthorizationStateEnum::cases(),'value'))->default(AuthorizationStateEnum::SENDED->value);
            $table->unsignedBigInteger("authorized_by")->nullable();
            $table->foreign("authorized_by")->references("id")->on("users");
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
