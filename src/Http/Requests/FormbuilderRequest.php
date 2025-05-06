<?php

namespace MedianetDev\BackpackForm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormbuilderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $locale = locale();
        return [
            $locale .'.title'       => 'required|min:3|max:255',
            $locale .'.text_button'       => 'required|min:1|max:255',
            'intro'       => 'nullable',
            'form'        => 'nullable',
            'mail_to'     => 'required_if:by_mail,1|max:255',
            'field_mail_name'     => 'required_if:copy_user,1|max:255',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        $language = default_language();
        $attributes[$language . '.title'] = __('medianet-dev.backpack-form::formbuilder.labels.title') . ' ' . trans('medianet-dev.backpack-form::formbuilder.common.in_langue') . ' ' . trans('medianet-dev.backpack-form::formbuilder.languages.' . $language);
        $attributes['intro'] =__('medianet-dev.backpack-form::formbuilder.labels.intro');
        $attributes['form'] =  __('medianet-dev.backpack-form::formbuilder.labels.form');
        $attributes['text_button'] =   __('medianet-dev.backpack-form::formbuilder.labels.text_button');
        $attributes['mail_to'] =  __('medianet-dev.backpack-form::formbuilder.labels.mail_to');
        $attributes['by_mail'] =  __('medianet-dev.backpack-form::formbuilder.labels.by_mail');
        return $attributes;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {

        return [
            'mail_to.required_if'         => __('medianet-dev.backpack-form::formbuilder.validations.mail_to'),
            'field_mail_name.required_if' => __('medianet-dev.backpack-form::formbuilder.validations.field_mail_name'),
        ];
    }
}
