<?php

use App\Enums\OfferStatusEnum;
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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->enum('status', OfferStatusEnum::getValues())->default(OfferStatusEnum::pending);

            $table->unsignedBigInteger('deal_id')->unsigned();
            $table->foreign('deal_id')->references('id')->on('deals')
                ->onDelete('cascade');

            $table->unsignedBigInteger('driver_id')->unsigned()->nullable();
            $table->foreign('driver_id')->references('id')
                ->on('users')
                ->onDelete('cascade');

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
        Schema::dropIfExists('offers');
    }
};
