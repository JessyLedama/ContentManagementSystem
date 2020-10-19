<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon-->
        <link rel="icon" href="{{ asset('images/alami-home-fashion-logo.png') }}" type="image/*">

        <title>
            @section('title')
                JGPMC
            @show
        </title>

        <!-- seo -->
        @section('seo')
            <meta name="keywords" content="">
            <meta name="description" content="">
        @show

        <!-- css -->
        <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/solid.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/LineIcons-master/LineIcons.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

        @yield('css')

        <!-- font -->
        <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

        <!-- js -->
        <script src="{{ asset('js/axios.min.js') }}"></script>
        <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('js/vue.min.js') }}"></script>
        <script src="{{ asset('js/vuex.js') }}"></script>

        <script>
            window.onbeforeunload = function () {
    
                window.scrollTo(0, 0);
            }
        </script>
    </head>

    <body>
        @include('layout.navbar')

        <div id="app">
            <nav-bar></nav-bar>
            @yield('content')
        </div>

        @include('layout.footer')

        @yield('components')

        @include('store')

        @stack('script')
    </body>
</html>