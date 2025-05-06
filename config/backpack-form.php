<?php

return [

    // Add or remove style from form package
    'styles' => [
        'https://cdn.form.io/formiojs/formio.full.min.css'
    ],

    // Add or remove script if already call in your header
    'scripts' => [
        'https://cdn.form.io/formiojs/formio.full.min.js',
    ],

    'model_form' => MedianetDev\BackpackForm\Models\Formbuilder::class,

    'button_class' => 'btn btn-primary',

    'email' => [
        // enter the email for receipient if yout form are sending by mail
        'form' => config('mail.from.address', 'admin-from@test-laravel.com'),
        'to' => config('mail.from.address', 'admin-to@test-laravel.com'),
    ],
    'captcha_v3_site_key' => env('FB_CAPTCHA_SITE_KEY', null),
    'captcha_v3_secret_key' => env('FB_CAPTCCHA_SECRET_KEY', null),
];
