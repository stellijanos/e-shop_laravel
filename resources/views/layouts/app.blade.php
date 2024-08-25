<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{asset('images/icons/shopping.png')}}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <script>
            window.addEventListener('pageshow', function (event) {
                if (event.persisted || (window.performance && window.performance.navigation.type == 2)) {
                    window.location.reload();
                }
            });
        </script>

        <style>
            ::-webkit-scrollbar {
                width: 0px;
            }

            #spinner-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 1000%;
                background: rgba(0, 0, 0, 0);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1050;

            }

            .spinner-border {
                width: 3rem;
                height: 3rem;
                border-width: 0.25em;
            }

            a.dropdown-item:hover {
                background-color: lightgray;
            }

            li.nav-item {
                border-radius: 10px;
            }

            li.nav-item:hover {
                background-color: lightgray;
            }

            footer {
                bottom: 0;
                width: 100%;
                height: 2.5rem;
            }


            .top-middle {
                position: fixed;
                top: 0;
                left: 50%;
                z-index: 9999;
                transform: translateX(-50%);
                width:80%;
                max-width:500px;
                text-align:center;
            }
        </style>
    </head>

    <body class="bg-secondary-subtle">
        <div class="overlay" id="spinner-overlay">
            <div class="spinner-border" role="status" id="spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div id="app" style="display:none">
            @include('includes.navbar')

            <div id="alert" class="top-middle"></div>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
        <footer class="text-center" style="display:none">&copy; Stelli Janos. All rights reserved.</footer>
    </body>

</html>