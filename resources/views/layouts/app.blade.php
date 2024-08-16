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
            <nav class="navbar navbar-expand-md navbar-light bg-transparent shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <div class="d-flex align-items-center">
                            <img src="{{asset('images/icons/shopping-cart.png')}}"
                                style="width:20px; height:20px; margin-top:-5px">
                            <span> {{ config('app.name', 'Laravel') }}</span>
                        </div>
                    </a>
                    <div class="vr" style="margin-right:10px"></div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->


                        <ul class="navbar-nav me-auto">
                            <form class="input-group" action="{{route('home')}}" method="get">
                                <input type="search" class="form-control" style="width:25vw;" value="{{$search ?? ''}}"
                                    name="search" id="search-string" placeholder="Search items...">
                                <button class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        style="font-size:1.25rem" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" v-pre>
                                        <i class="fa-solid fa-user"></i> {{ Auth::user()->firstname }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                        @if(Auth::user()->isEmployee())
                                            <a href="{{url('/employee')}}" class="dropdown-item">ADMIN Panel</a>
                                        @endif

                                        <a href="{{url('/account')}}" class="dropdown-item">My Account</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                                @if(auth()->user()->isCustomer())
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('favourites.show')}}" style="font-size:1.25rem">
                                            <i class="fa-solid fa-heart position-relative">
                                                <span style="font-size: 12px; padding: 3px 6px;"
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger">
                                                    <span id="favourites-count-badge">{{count($favourites)}}</span>
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </i> Favourites</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('cart')}}" style="font-size:1.25rem">
                                            <i class="fa-solid fa-cart-shopping position-relative">
                                                <span style="font-size: 12px; padding: 6px 6px;"
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger">
                                                    <span id="cart-count-badge">{{$nrOfCartProducts}}</span>
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </i> Cart
                                        </a>
                                    </li>
                                @endif
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="alert" class="top-middle"></div>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
        <footer class="text-center" style="display:none">&copy; Stelli Janos. All rights reserved.</footer>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const spinner = document.getElementById('spinner-overlay');
                const app = document.getElementById('app');
                const footer = document.getElementsByTagName('footer')[0];

                window.onload = () => {
                    // document.body.removeChild(spinner);
                    spinner.style.display = 'none';
                    spinner.style.background = 'rgba(0, 0, 0, 0.2)';
                    app.style.display = 'block';
                    footer.style.display = 'block';
                };
            });
        </script>
    </body>

</html>