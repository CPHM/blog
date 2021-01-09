<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>@yield('title', env('APP_NAME', 'Blog'))</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/fonts.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/icomoon.css')}}"/>
    <meta name="description" content="@yield('description', '')"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @yield('head')
</head>
<body class="font-roboto">
@yield('body')
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
