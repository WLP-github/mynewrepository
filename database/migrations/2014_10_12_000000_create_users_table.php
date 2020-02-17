<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->unsignedInteger('department_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_registration_no')->unique()->nullable();
            $table->string('company_phone_no')->nullable();
            $table->dateTime('registration_date')->nullable();
            $table->string('applicant_name', 150);
            $table->string('applicant_phone_no', 50)->nullable();
            $table->string('applicant_nrc', 50);
            $table->boolean('is_active')->default(0);
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('role')->default(99);
            $table->integer('role_id')->default(3);
            $table->rememberToken();
            $table->dateTime('cancel_time')->nullable();
            $table->timestamps();
            $table->string('session_id')->nullable();

            $table->index('email');
            $table->index('company_name');
            $table->index('company_registration_no');
            $table->index('registration_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
