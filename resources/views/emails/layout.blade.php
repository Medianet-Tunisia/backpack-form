<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{{ $dataMail['orginal_form']->subject_admin ?? __('medianet-dev.backpack-form::formbuilder.emails.default_subject', ['app_name' => config('app.name')])}}</title>
        @include('medianet-dev.backpack-form::emails.styles')
    </head>
    <body>
        @yield('content_fb_email')
    </body>
</html>
