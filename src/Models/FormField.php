<?php

namespace MedianetDev\BackpackForm\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\App;

class FormField extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'med_form_fields';
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'key',
        'form_id',
        'form_step_id',
        'type',
        'is_required',
        'is_active',
        'order',
        'formio_component',
        'validation_rules',
        'order',
    ];



    public function translation()
    {
        return $this->hasOne(FormFieldTranslation::class)->where('locale', locale());
    }

    public function translations()
    {
        return $this->hasMany(FormFieldTranslation::class);
    }
    public function conditions()
    {
        return $this->hasMany(FormFieldCondition::class, 'form_field_id');
    }

    /**
     * Get translated attribute
     *
     * @param string $attribute
     * @param string|null $locale
     * @return mixed
     */
    public function getTranslatedAttribute($attribute, $locale = null)
    {
        $locale = $locale ?: locale();

        if ($translation = $this->translations->where('locale', $locale)->first()) {
            return $translation->{$attribute};
        }

        return null;
    }







    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the form that owns the field
     */
    public function form()
    {
        return $this->belongsTo(Formbuilder::class, 'form_id');
    }

    /**
     * Get the form step that owns the field
     */
    public function formStep()
    {
        return $this->belongsTo('MedianetDev\BackpackForm\Models\FormStep', 'form_step_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Only active fields
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Only required fields
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
