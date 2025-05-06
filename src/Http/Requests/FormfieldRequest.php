<?php

namespace MedianetDev\BackpackForm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormfieldRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $locale = app()->getLocale();
        return [
          //  'key' => 'required|string|unique:med_form_fields,key',
            'form_id' => 'required|exists:med_forms,id',
            'form_step_id' => 'required|exists:med_form_steps,id',
            'type' => 'required|string|in:textfield,textarea,number,password,checkbox,selectboxes,select,radio,button,email,url,phoneNumber,address,datetime,day,time,currency,signature,file,content,columns,fieldset,panel,table,tabs,well,hidden',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'formio_component' => 'nullable|json',
            'validation_rules' => 'nullable|json',
            "{$locale}.label" => 'required|string|max:255',
            "{$locale}.placeholder" => 'nullable|string|max:255',
        ];
    }
}
