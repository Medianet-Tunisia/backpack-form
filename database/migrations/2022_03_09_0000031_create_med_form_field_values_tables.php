<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedFormFieldValuesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('med_form_field_values')) {
            Schema::create('med_form_field_values', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('form_field_id')->nullable();
                $table->foreign('form_field_id')
                    ->references('id')
                    ->on('med_form_fields')
                    ->onDelete('set null');
                $table->boolean('default_selected')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('med_form_field_value_translations')) {
            Schema::create('med_form_field_value_translations', function (Blueprint $table) {
                $table->id();
                $table->string('value');
                $table->text('text')->nullable();

                $table->unsignedBigInteger('field_value_id')->nullable();
                $table->foreign('field_value_id')
                    ->references('id')
                    ->on('med_form_field_values')
                    ->onDelete('set null');
                $table->text('description')->nullable();
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
        Schema::dropIfExists('med_entries');
        Schema::dropIfExists('med_form_translations');
        Schema::dropIfExists('med_forms');
    }
}
