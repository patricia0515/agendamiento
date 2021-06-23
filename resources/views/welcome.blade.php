<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    {{-- <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', '') }}
                    </a> --}}
                    <img class="navbar-brand" src="img/logo-famisanar.png" alt="famisanar" width="300" height="90">
                </div>
            </nav>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col">
                        <div class="card">
                            <v-app>
                                <buscarpersonas-component></buscarpersonas-component>
                            </v-app>
                        </div>
                    </div>
                </div>       
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
