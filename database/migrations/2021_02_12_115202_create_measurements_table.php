<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('ph', 10)->nullable();
            $table->string('tmp', 10)->nullable();
            $table->string('cod', 10)->nullable();
            $table->string('tss', 10)->nullable();
            $table->string('nh3n', 10)->nullable();
            $table->string('debit', 10)->nullable();
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
        Schema::dropIfExists('measurements');
    }
}
