<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token"   id="token"   value="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.codetube = {
            url : '{{ config('app.url') }} ',
            user : {
                id : {{ Auth::check() ? Auth::user()->id : 'null' }},
                authenticated : {{ Auth::check() ? 'true' : 'false' }}

            }
        };
    </script>

</head>
<body>
    <div id="app">

        @include('layouts.partials._navigation')

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
