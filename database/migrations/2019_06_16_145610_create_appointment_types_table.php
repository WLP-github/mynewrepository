<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('appointment_category_id');
            $table->dateTime('entry_date');
            $table->time('start_time');
            $table->string('allow_days');
            $table->timestamps();

            $table->index(['name','entry_date','start_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_types');
    }
}
