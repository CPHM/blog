<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if(View::hasSection('title'))
            {{env('APP_NAME', 'Blog')}} - @yield('title')
        @else
            {{env('APP_NAME', 'Blog')}}
        @endif
    </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/fonts.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/icomoon.css')}}"/>
    @if(View::hasSection('description'))
        <meta name="description" content="@yield('description')"/>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @yield('head')
</head>
<body class="font-roboto">
@yield('body')
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
