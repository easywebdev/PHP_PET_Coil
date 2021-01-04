<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoilCoilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coil_coils', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('designs_id');
            $table->unsignedBigInteger('wires_id');

            $table->foreign('designs_id')->references('id')->on('coil_designs');
            $table->foreign('wires_id')->references('id')->on('coil_wires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coil_coils');
    }
}
