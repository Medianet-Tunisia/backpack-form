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
        if (!Schema::hasTable('med_forms')) {
            Schema::create('med_forms', function (Blueprint $table) {
                $table->id();
                $table->uuid('uniq_id');
                $table->text('intro')->nullable();
                $table->boolean('in_database')->default(0);
                $table->boolean('by_mail')->default(0);
                $table->boolean('display_captcha')->default(0);
                $table->string('mail_to', 255)->nullable();
                $table->boolean('include_data')->default(0);
                $table->string('subject_admin', 255)->nullable();
                $table->text('message_admin')->nullable();
                $table->boolean('copy_user')->default(0);
                $table->string('field_mail_name')->nullable();
                $table->string('subject_user', 255)->nullable();
                $table->text('message_user')->nullable();
                $table->boolean('display_title')->default(1);
                $table->boolean('display_intro')->default(1);
                $table->boolean('display_header')->default(1);
                $table->boolean('display_footer')->default(1);
                $table->boolean('multiple_steps')->default(0);
                $table->json('formio_component')->nullable();
                $table->json('validation_rules')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('med_form_translations')) {
            Schema::create('med_form_translations', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255)->nullable();
                $table->string('text_button');
                $table->string('slug')->nullable();
                $table->string('locale')->nullable();
                $table->text('description')->nullable();
                $table->text('header')->nullable();
                $table->text('footer')->nullable();
                $table->timestamps();
                $table->unsignedBigInteger('form_id')->nullable();
                $table->foreign('form_id')
                    ->references('id')
                    ->on('med_forms')
                    ->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('med_entries')) {
            Schema::create('med_entries', function (Blueprint $table) {
                $table->id();
                $table->text('structure_form')->nullable();
                $table->text('structure_result')->nullable();
                $table->unsignedBigInteger('fb_form_id');
                $table->timestamps();
                $table->foreign('fb_form_id')->references('id')->on('med_forms');
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
