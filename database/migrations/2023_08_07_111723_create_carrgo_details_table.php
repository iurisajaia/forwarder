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
        Schema::create('carrgo_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carrgo_id');
            $table->string('carrgo_type')->nullable();
            $table->integer('weight')->nullable();
            $table->enum('weight_type' , ['kilogram', 'pound'])->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('length')->nullable();
            $table->integer('trailer_type_id')->nullable();
            $table->foreign('carrgo_id')->references('id')->on('carrgos')->onDelete('cascade');
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
        Schema::dropIfExists('carrgo_details');
    }
};
