<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNrcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nrcs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state_number');
            $table->string('short_district');
            $table->string('long_district');
            $table->string('short_district_mm');
            $table->timestamps();

            $table->index('state_number');
            $table->index('short_district_mm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nrcs');
    }
}
