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
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('number')->nullable();
            $table->string('model')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('key')->nullable();
            $table->string('icon_default')->nullable();
            $table->string('icon_hover')->nullable();
            $table->integer('trailer_type_id')->nullable();
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
        Schema::dropIfExists('trailers');
    }
};
