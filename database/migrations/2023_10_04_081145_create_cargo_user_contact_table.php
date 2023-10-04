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
        Schema::create('cargo_user_contact', function (Blueprint $table) {
            $table->unsignedBigInteger('cargo_id')->unsigned();

            $table->unsignedBigInteger('user_contact_id')->unsigned();

            $table->foreign('cargo_id')->references('id')->on('cargos')

                ->onDelete('cascade');

            $table->foreign('user_contact_id')->references('id')->on('user_contacts')

                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargo_user_contact');
    }
};
