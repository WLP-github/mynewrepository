<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appointment_id');
            $table->date('appointment_date');
            $table->integer('item_amount');
            $table->unsignedInteger('appointment_category_id');
            $table->unsignedInteger('slot_id');
            $table->unsignedInteger('user_id');
            $table->string('applicant_name')->nullable();
            $table->string('applicate_phone_no')->nullable();
            $table->string('applicant_nrc')->nullable();
            $table->string('brand_name')->nullable();
            $table->boolean('is_cancel')->default(0);
            $table->boolean('status')->default(1);
            $table->unsignedInteger('canceled_by')->nullable();
            $table->string('letter_name')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
