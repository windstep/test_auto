<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'car_usage',
            function (Blueprint $table) {
                $table->id();
                $table->dateTime('time_from');
                $table->dateTime('time_to');
                $table->foreignId('user_id');
                $table->foreignId('car_id');
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('car_id')->references('id')->on('cars')
                    ->onUpdate('cascade')->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('auto_usage');
        Schema::enableForeignKeyConstraints();
    }
}
