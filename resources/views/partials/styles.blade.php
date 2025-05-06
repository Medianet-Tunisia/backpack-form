@if (config('backpack-form.styles') && count(config('backpack-form.styles')))
    @foreach (config('backpack-form.styles') as $path)
        <link rel="stylesheet" type="text/css" href="{{ asset($path) }}"></link>
    @endforeach
@endif