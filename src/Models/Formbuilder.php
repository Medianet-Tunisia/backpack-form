<?php

namespace MedianetDev\BackpackForm\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\App;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Formbuilder extends Model
{
    use CrudTrait, LogsActivity;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'med_forms';
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function entriesList()
    {
        return '<a href="' . backpack_url('formbuilder/' . $this->id . '/formbuilderentry') . '" class="btn btn-sm btn-link"><i class="la la-bar-chart"></i> ' . __('medianet-dev.backpack-form::formbuilder.labels.view_entries') . '</a>';
    }
    public function form_edit()
    {
        return '<a href="' . backpack_url('form-fields/create') . '" class="btn btn-sm btn-link open-popup-link"><i class="la la-bar-chart"></i> EDIT</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function entries()
    {
        return $this->hasMany(FormbuilderEntry::class);
    }

    public function translation()
    {
        return $this->hasOne(FormbuilderTranslation::class, 'form_id')
            ->where('locale', App::getLocale());
    }

    public function translations()
    {
        return $this->hasMany(FormbuilderTranslation::class, 'form_id');
    }

    public function steps()
    {
        return $this->hasMany(FormStep::class, 'form_id');
    }
    public function getTranslatedTitleAttribute()
    {
        return optional($this->translation)->title ?? $this->id;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id',
                'display_intro',
                'display_title',
                'display_header',
                'display_footer',
                'uniq_id',
                'intro',
                'text_button',
                'form',
                'in_database',
                'by_mail',
                'display_captcha',
                'mail_to',
                'include_data',
                'subject_admin',
                'message_admin',
                'copy_user',
                'field_mail_name',
                'subject_user',
                'message_user',
                'multiple_steps',
                'formio_component',
                'validation_rules',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(
                fn(string $eventName) => ("activity.action.{$eventName}")
            )
            ->useLogName('form');
    }
}
