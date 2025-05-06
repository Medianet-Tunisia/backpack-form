@if (config('backpack-form.scripts') && count(config('backpack-form.scripts')))
    @foreach (config('backpack-form.scripts') as $path)
        <script type="text/javascript" src="{{ asset($path) }}"></script>
    @endforeach
@endif
