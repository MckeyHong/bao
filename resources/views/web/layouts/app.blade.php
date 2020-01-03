<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ trans('custom.websiteName') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        @yield('css')
    </head>
    <body>
        @include('web.layouts.header')
        @yield('content')
        @include('web.layouts.footer')
        @yield('js')
    </body>
</html>
