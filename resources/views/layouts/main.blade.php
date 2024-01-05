<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Upload manager')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('vendor/uploader/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/uploader/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/uploader/css/filemanager.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/uploader/css/uploadmanager.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/uploader/css/filesetter.css') }}">
    </head>
    <body class="font-sans antialiased">
        <header id="header">
            <div class="left">

            </div>
            <div class="right" role="popup">

            </div>
        </header>
        @yield('content')

        <!-- Scripts -->
        <script src="{{ asset('vendor/uploader/js/jquery.min.js') }}"></script>
    </body>
</html>
