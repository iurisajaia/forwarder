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
        Schema::create('cargo_details', function (Blueprint $table) {
            $table->id();
            $table->enum('weight_type' , ['kilogram', 'tons'])->nullable();
            $table->bigInteger('weight')->nullable();
            $table->bigInteger('width')->nullable();
            $table->bigInteger('height')->nullable();
            $table->bigInteger('length')->nullable();
            $table->bigInteger('degree')->nullable();

            $table->unsignedBigInteger('cargo_id');
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');
            $table->unsignedBigInteger('packaging_type_id');
            $table->foreign('packaging_type_id')->references('id')->on('packaging_types')->onDelete('cascade');
            $table->unsignedBigInteger('danger_status_id');
            $table->foreign('danger_status_id')->references('id')->on('danger_statuses')->onDelete('cascade');

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
        Schema::dropIfExists('cargo_details');
    }
};
