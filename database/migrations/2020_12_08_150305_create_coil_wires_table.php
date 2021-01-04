<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoilWiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coil_wires', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('conductor_d');
            $table->double('full_d');
            $table->unsignedBigInteger('materials_id');

            $table->foreign('materials_id')->references('id')->on('coil_materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coil_wires');
    }
}
