<?php

if (! function_exists('renderFormBuilder')) {
    function renderFormBuilder($uuid)
    {
        $form = \MedianetDev\BackpackForm\Models\Formbuilder::where('uniq_id', $uuid)->firstOrNew();
        if (empty($form) || !isset($form->uniq_id) || empty($form->uniq_id)) {
            return view('medianet-dev.backpack-form::render_form', ['data' => json_encode([]), 'form' => new \MedianetDev\BackpackForm\Models\Formbuilder()]);
        }
        $formData = (!empty($form->form)) ? $form->form : json_encode([]);
        return view('medianet-dev.backpack-form::render_form', ['data' => $formData, 'form' => $form]);
    }
}
