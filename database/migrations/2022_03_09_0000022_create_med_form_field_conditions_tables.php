<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedFormFieldConditionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('med_form_field_conditions')) {
            Schema::create('med_form_field_conditions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('form_step_id')->nullable();
                $table->foreign('form_step_id')->references('id')->on('med_form_steps')->onDelete('set null');
                $table->unsignedBigInteger('form_field_id')->nullable();
                $table->foreign('form_field_id')->references('id')->on('med_form_fields')->onDelete('set null');
                $table->string('operation')->nullable();
                $table->string('eq')->nullable();
                $table->string('when')->nullable();
                $table->string('show')->nullable();
                $table->timestamps();
            });
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('med_form_field_conditions');
    }
}
