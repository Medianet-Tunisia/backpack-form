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

        if (!Schema::hasTable('med_form_steps')) {
            Schema::create('med_form_steps', function (Blueprint $table) {
                $table->id();
                $table->integer('order')->nullable();
                $table->string('key')->nullable();
                $table->boolean('is_active')->default(0);
                $table->unsignedBigInteger('form_id')->nullable();
                $table->foreign('form_id')
                ->references('id')
                ->on('med_forms')
                ->onDelete('set null');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('med_step_form_translations')) {
            Schema::create('med_form_step_translations', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255)->nullable();
                $table->string('locale')->nullable();
                $table->unsignedBigInteger('form_step_id')->nullable();
                $table->foreign('form_step_id')
                    ->references('id')
                    ->on('med_form_steps')
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
        // Drop tables in reverse order of creation to avoid foreign key constraint issues
        Schema::dropIfExists('med_entries');
        Schema::dropIfExists('med_form_translations');
        Schema::dropIfExists('med_forms');
        Schema::dropIfExists('formbuilders');
    }
}
