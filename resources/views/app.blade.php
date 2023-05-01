<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

        <script src="{{ url('app-assets/vendors/js/vendors.min.js') }}"></script>
        <script src="{{ url('app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js') }}"></script>
        <script src="{{ url('app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js') }}"></script>
        <script src="{{ url('app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', 'resources/js/app-init.js'])

        {{-- <?php Route::current()->getName(); ?> --}}
         @vite(['resources/js/app.css.js'])
         {{ $styles ?? '' }}
        {{-- @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"]) --}}
        @vite(["resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 2-columns  navbar-sticky footer-static">
        @inertia

        {{ $scripts ?? '' }}
    </body>
</html>
