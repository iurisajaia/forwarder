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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->integer('user_role_id')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->boolean('user_data_is_verified')->nullable()->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

//        \DB::statement("UPDATE users SET password = NULL WHERE user_role_id = 6");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('users', function (Blueprint $table) {
//            $table->string('password')->nullable(false)->change();
//        });
        Schema::dropIfExists('users');
    }
};
