<?php

namespace MedianetDev\BackpackForm\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class FormbuilderEntry extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'med_entries';
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function formbuilder()
    {
        return $this->belongsTo(Formbuilder::class, 'fb_form_id');
    }
}
