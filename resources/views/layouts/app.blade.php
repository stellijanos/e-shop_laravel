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

    <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type == 2)) {
                window.location.reload();
            }
        });
    </script>

    <style>
        a.dropdown-item:hover {
            background-color:lightgray;
        }

        li.nav-item {
            border-radius:10px;
        }

        li.nav-item:hover {
            background-color: lightgray;
        }

        footer {
            bottom: 0;
            width: 100%;
            height: 2.5rem;
        }
    </style>


</head>
<body class="bg-secondary-subtle">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-transparent shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('images/icons/shopping-cart.png')}}" style="width:20px; height:20px; margin-top:-5px">
                        <span> {{ config('app.name', 'Laravel') }}</span>
                    </div>
                </a>
                <div class="vr" style="margin-right:10px"></div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    @if(Auth::user()->isCustomer())
                        <ul class="navbar-nav me-auto">
                            <form class="input-group" action="{{route('home')}}" method="get">
                                <input type="search" class="form-control" style="width:25vw;" value="{{$search ?? ''}}" name="search" id="search-string" placeholder="Search items...">
                                <button class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                            
                        </ul>
                    @endif

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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                 <i class="fa-solid fa-user"></i> {{ Auth::user()->firstname }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    @if(Auth::user()->isEmployee())
                                        <a href="{{url('/employee')}}" class="dropdown-item">ADMIN Panel</a>
                                    @endif

                                    <a href="{{url('/account')}}" class="dropdown-item">My Account</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @if(auth()->user()->isCustomer())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('favourites')}}"><i class="fa-solid fa-heart"></i> Favourites</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('cart')}}"><i class="fa-solid fa-cart-shopping"></i> Shopping Cart</a>
                                </li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer class="text-center">&copy; Stelli Janos. All rights reserved.</footer>
</body>
</html>
