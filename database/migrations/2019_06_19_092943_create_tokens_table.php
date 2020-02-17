<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            // $table->increments('id');
            $table->date('date');
            $table->tinyInteger('appointment_category_id');
            $table->tinyInteger('slot_id');
            $table->integer('limit_qty')->default(0);
            $table->integer('booked_qty')->default(0);
            $table->integer('available_qty')->default(0);
            $table->primary(['date','appointment_category_id', 'slot_id']);
            // $table->foreign('appointment_category_id')->references('id')->on('appointment_categories');
            // $table->foreign('slot_id')->references('id')->on('slots');
            $table->string("created_by");
            $table->string("updated_by");
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
        Schema::dropIfExists('tokens');
    }
}
