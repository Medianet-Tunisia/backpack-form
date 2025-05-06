<?php

namespace MedianetDev\BackpackForm\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FormbuilderTranslation extends Model
{
    use CrudTrait, LogsActivity;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'med_form_translations';
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'title',
        'description',
        'slug',
        'header',
        'footer',
        'locale',
        'form_id',
        'text_button',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function formbuilder()
    {
        return $this->belongsTo(Formbuilder::class, 'form_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'text_button',
                'slug',
                'locale',
                'description',
                'header',
                'footer',
                'form_id',
                'created_at',
                'updated_at'
            ])

            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(
                fn(string $eventName) => ("activity.action.{$eventName}")
            )
            ->useLogName('form_translation');
    }
}
