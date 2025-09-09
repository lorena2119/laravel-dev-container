@component('mail::message')
    # ¡Hello, {{$user->name}}!
    ## Tu registro fue tan exitoso como tu destino.
    Ya puedes usar la API.

    @component('mail::button', ['url' => config('app.url')])
        Ir a la app 🤫
    @endcomponent
    
    Gracias, con mucho cariño,
    {{config('app.name')}} ❤️
@endcomponent
