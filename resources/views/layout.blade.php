<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="coil calculator, coil design, magnetic field, inductance, fill factor, loops">
        <meta name="description" content="Coil calculator provides possibilities calculate basic coil's parameters such as magnetic field, inductance, power, wire resistance, wire length, wire loop counts.">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{asset('js/jquery-3.3.1.js')}}" type="application/javascript"></script>
        <script src="{{asset('js/chart.js')}}" type="application/javascript"></script>

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/reset.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/chart.css') }}" rel="stylesheet">

    </head>

    <body>
        <header class="s-header">
            <div class="container p-1rem bb mb-1rem">
                <h1 class="h1">
                    Coil Calculator
                </h1>
            </div>
        </header>

        @yield('content')

        <footer class="footer">
            <div class="container footer-block">
                &copy; IT-EXPERIENCE
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
