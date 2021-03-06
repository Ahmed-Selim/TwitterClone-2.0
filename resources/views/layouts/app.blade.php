<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TwitterClone') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
    crossorigin="anonymous"></script>
    <script>window.Popper || document.write('<script src="static/lib/popper.min.js"><\/script>')</script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
            crossorigin="anonymous"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .form-control {
            /* --bs-bg-opacity: 1; */
            background-color: transparent !important;
        }
    </style>
    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'TwitterClone') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if (Auth::user()->profile)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profiles.show', Auth::user()->profile) }}">Home</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">Explore</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#">Followers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Following</a>
                            </li> -->

                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav d-flex w-75 justify-content-around">

                        {{-- <form class="form-inline col-9 justify-content-center">
                            <div class="input-group col-10 border rounded-pill">
                                <div class="input-group-prepend">
                                    <span
                                        class="bg-white border-0 pr-2 input-group-text"
                                        id="searchLabel">@</span>
                                </div>
                                <input type="text"
                                    class="form-control border-0 pl-0"
                                    placeholder="Search TwitterClone"
                                    aria-describedby="searchLabel">
                            </div>
                        </form> --}}
                        <profile-search-form></profile-search-form>

                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->profile->name ?? 'New User' }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->profile)
                                    <a class="dropdown-item" href="{{ route('profiles.show', Auth::user()->profile) }}">
                                        Profile
                                    </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            @auth
                {{--
                <a href="{{ route('tweets.create') }} " id="floating"
                    class="btn btn-outline-primary shadow rounded-pill font-weight-bold">
                        + Tweet
                </a>
                --}}
                <new-tweet-btn></new-tweet-btn>
            @endauth
        </main>
    </div>
</body>
</html>
