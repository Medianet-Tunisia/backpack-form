<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('med_form_field_val_tab')) {
            Schema::create('med_form_field_val_tab', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('form_field_id')->nullable();
                $table->foreign('form_field_id')
                    ->references('id')
                    ->on('med_form_fields')
                    ->onDelete('set null');
                $table->string('table_name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('med_form_field_val_tab_translations')) {
            Schema::create('med_form_field_val_tab_translations', function (Blueprint $table) {
                $table->id();
                $table->string('value');
                $table->text('text')->nullable();
                $table->unsignedBigInteger('val_tab_id')->nullable();
                $table->foreign('val_tab_id')
                    ->references('id')
                    ->on('med_form_field_val_tab')
                    ->onDelete('set null');
                $table->string('locale')->nullable();
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
        Schema::dropIfExists('med_form_field_val_tab_translations');
        Schema::dropIfExists('med_form_field_val_tab');
    }
}