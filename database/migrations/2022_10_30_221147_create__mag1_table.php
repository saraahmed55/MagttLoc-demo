<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMag1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_mag1', function (Blueprint $table) {
            $table->id();
            $table->string('predicted_y_distance');
            $table->string('predicted_x_distance');
            $table->string('actual_y_distance');
            $table->string('actual_x_distance');
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
        Schema::dropIfExists('_mag1');
    }
}
