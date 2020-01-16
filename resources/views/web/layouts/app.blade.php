<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ $browserTitle }} {{ __('custom.websiteName') }}</title>
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/web/initial.css') }}">
        @yield('css')
        <script src="{{ asset('js/vendor/eva.min.js') }}"></script>
    </head>
    <body>
        <div id="app" class="container">
            @include('web.layouts.header')
            @include('web.layouts.menu')
            <div class="container-fluid">
                @yield('content')
            </div>
            @include('web.layouts.footer')
        </div>
        <div id="loading"><img src="{{ asset('images/loading.svg') }}" title="loading" /></div>
        <div id="gotop"><img src="{{ asset('images/top.png') }}" width="36px"></div>
        <script src="{{ mix('/js/app.js') }}"></script>
        <script>
            axios.defaults.headers.common['Authorization'] = 'Bearer {{ $member['api_token'] }}';
        </script>
        <script src="{{ mix('/js/web/initial.js') }}"></script>
        @yield('js')
    </body>
</html>
