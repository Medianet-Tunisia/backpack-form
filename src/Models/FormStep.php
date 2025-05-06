<?php

namespace MedianetDev\BackpackForm\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\App;

class FormStep extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'med_form_steps';
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function translation()
    {
        return $this->hasOne(FormStepTranslation::class)->where('locale', App::getLocale());
    }

    public function translations()
    {
        return $this->hasMany(FormStepTranslation::class);
    }
  
    public function form()
    {
    return $this->belongsTo(Formbuilder::class,'form_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function getTranslatedTitleAttribute()
{
    return optional($this->translation)->title ?? $this->id;
}

}
