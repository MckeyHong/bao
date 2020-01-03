<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ trans('custom.websiteName') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        @yield('css')
    </head>
    <body>
        <div id="app" class="container-fluid">
            @include('web.layouts.header')
            @yield('content')
            @include('web.layouts.footer')
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
        @yield('js')
    </body>
</html>
