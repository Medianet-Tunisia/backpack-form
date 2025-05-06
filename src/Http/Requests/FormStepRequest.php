<?php

namespace MedianetDev\BackpackForm\Http\Requests;

use App\Models\DocumentVersionTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormStepRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        $locale = locale();
        $id = request()->id;
        return [
            $locale . '.title'       => 'required|min:3|max:255',
            $locale . '.description' => 'nullable',
            'is_active'              => 'required|boolean',
            'order' => [
                'required',
                'integer',
                Rule::unique('med_form_steps', 'order')->where(function ($query) {
                    return $query->where('form_id', request()->form_id);
                })->ignore($id),
            ],

            'form_id'      => 'required|integer|exists:med_forms,id',
        ];

    }

    public function attributes()
    {
        $language = default_language();
        $attributes[$language . '.title'] = __('medianet-dev.backpack-form::formbuilder.labels.title') . ' ' . trans('medianet-dev.backpack-form::formbuilder.common.in_langue') . ' ' . trans('medianet-dev.backpack-form::formbuilder.languages.' . $language);
        $attributes['order'] = __('medianet-dev.backpack-form::formbuilder.labels.order');
        return $attributes;
    }
    public function messages()
    {
        return [];
    }
}
