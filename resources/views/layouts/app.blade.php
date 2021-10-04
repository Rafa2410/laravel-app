<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.default_locale = "{{ app()->getLocale() }}";
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Language switcher -->                            
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> {{ Config::get('languages')[App::getLocale()]['display'] }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                @foreach (Config::get('languages') as $lang => $language)
                                    @if ($lang != App::getLocale())
                                        <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"><span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span> {{$language['display']}}</a>
                                    @endif
                                @endforeach
                            </div>
                        </li>
                        <!-- Authentication Links -->
                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <div class="wrapper container-fluid">
            <div class="row" style="width: 100%;">
                @auth
                <div class="col-sm-2 d-none d-md-block" style="padding-left: 0;">
                    <nav id="sidebar">
                        <div class="sidebar-header" style="padding: 0;">
                            <img src="https://www.ficosa.com/wp-content/uploads/2017/01/Ficosa-Logo_Horizontal.jpg" style="max-width:100%;" alt="Ficosa logo">
                        </div>

                        <ul class="list-unstyled components">
                            @if (@Auth::user()->hasPermissionTo('request-list') || @Auth::user()->hasRole('Admin'))
                                <li class="{{ (request()->is('requests*')) ? 'nav-item active' : 'nav-item' }}">
                                    <a class="nav-link" href="{{ route('requests.index') }}">{{ __('Requests') }} </a>
                                </li>
                            @endif
                            @if (@Auth::user()->hasPermissionTo('role-list') || @Auth::user()->hasRole('Admin'))
                                <li class="{{ (request()->is('roles*')) ? 'nav-item active' : 'nav-item' }}">
                                    <a class="nav-link" href="{{ route('roles.index') }}">{{ __('Manage Roles') }}</a>
                                </li>
                                <li class="{{ (request()->is('users*')) ? 'nav-item active' : 'nav-item' }}">
                                    <a class="nav-link" href="{{ route('users.index') }}">{{ __('Manage Users') }}</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="col-sm-12 col-md-10">
                @endauth
                @guest
                <div class="col-sm-12">
                @endguest
                    <div id="content">
                        <main class="container py-4">
                            @yield('content')
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
