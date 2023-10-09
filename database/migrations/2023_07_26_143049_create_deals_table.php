<?php

use App\Enums\CurrencyEnum;
use App\Enums\DealStatusEnum;
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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();

            $table->enum('status', DealStatusEnum::getValues())->default(DealStatusEnum::in_progress);
            $table->enum('currency', CurrencyEnum::getValues())->default(CurrencyEnum::GEL)->nullable();
            $table->integer('price')->nullable();

            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('cargo_id')->unsigned();
            $table->foreign('cargo_id')->references('id')->on('cargos')
                ->onDelete('cascade');

            $table->unsignedBigInteger('driver_id')->unsigned()->nullable();
            $table->foreign('driver_id')->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('car_id')->unsigned()->nullable();
            $table->foreign('car_id')->references('id')
                ->on('cars')
                ->onDelete('cascade');

            $table->unsignedBigInteger('invoice_id')->unsigned()->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices')
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
        Schema::dropIfExists('deals');
    }
};
