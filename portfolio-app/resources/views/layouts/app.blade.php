<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cards_aside.css') }}">
    <link rel="stylesheet" href="{{ asset('css/card_contents.css') }}">
    @yield('styles')

    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
            position: relative;
        }
    </style>
</head>
<body>

    @include('components.top-bar')

    @yield('content')

    @yield('scripts')
</body>
</html>
