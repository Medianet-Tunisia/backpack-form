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
        if (!Schema::hasTable('med_form_fields')) {
            Schema::create('med_form_fields', function (Blueprint $table) {
                $table->id();
                $table->string('key'); 
                $table->unsignedBigInteger('form_id')->nullable();
                $table->foreign('form_id')->references('id')->on('med_forms')->onDelete('set null');
                $table->unsignedBigInteger('form_step_id')->nullable();
                $table->foreign('form_step_id')->references('id')->on('med_form_steps')->onDelete('set null');
                $table->string('type')->nullable();
                $table->boolean('is_required')->default(false);
                $table->boolean('is_active')->default(true);
                $table->integer('order')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('med_form_field_translations')) {
            Schema::create('med_form_field_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('form_field_id')->nullable();
                $table->foreign('form_field_id')->references('id')->on('med_form_fields')->onDelete('cascade');
                $table->string('locale')->nullable();
                $table->string('label')->nullable();
                $table->string('placeholder')->nullable();
                $table->text('description')->nullable();
                $table->string('default_value')->nullable();
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
        Schema::dropIfExists('med_form_field_translations');
        Schema::dropIfExists('med_form_fields');
        // You might want to review these, as they seem to be unrelated to the tables created in up()
        Schema::dropIfExists('med_entries');
        Schema::dropIfExists('med_form_translations');
        Schema::dropIfExists('med_forms');
    }
}
