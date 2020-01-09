<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ $browserTitle }} {{ trans('custom.websiteName') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        @yield('css')
        <style type="text/css">
        html, body {
            background: #FEFEFE;
            position: relative;
        }
        a {
            color: #000000;
        }

        a:hover {
            text-decoration: none;
            color: #000000;
        }

        .header-nav {
            background-color: #E6381D;
            width: 100%;
            height: 55px;
            position: fixed;
            z-index: 100;
        }

        .menu-container {
            background-color: #FEFEFE;
            border-bottom: 1px solid #cccccc;
            color: #FF671A;
            margin: 0;
            padding-top: 56px;
            position: fixed;
            width: 100%;
            height: 120px;
            z-index: 99;
        }

        .menu-block {
            margin: 8px auto;
            text-align: center;
            padding: 0 5px;
        }

        .container-fluid {
            padding: 0px;
            margin: 0px;
            padding-top: 130px;
        }

        .btn-submit {
            color: #ffffff;
            background: #E6381D;
            border-color: #E6381D;
        }

        .btn-submit:hover {
            color: #ffffff;
            background: #DD2F2F;
            border-color: #DD2F2F;
        }

        #loading {
            position: fixed;
            z-index: 10000;
            top: 0;
            left: 0;
            background: #cccccc;
            width: 100%;
            height: 100%;
            opacity: 0.5;
            display: none;
        }

        #loading img {
            position: absolute;
            top: 35%;
            left: 35%;
            width: 35%;
        }

        #gotop {
            display: none;
            position: fixed;
            right: 20px;
            bottom: 20px;
            padding: 6px 10px;
            font-size: 10px;
            color: white;
            cursor: pointer;
            z-index: 999;
        }

        #app {
            position: relative;
            padding: 0;
        }
        </style>
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
        <div id="loading">
            <img src="{{ asset('images/loading.svg') }}" />
        </div>
        <div id="gotop"><img src="{{ asset('images/top.png') }}" width="36px"></div>
        <script src="{{ mix('/js/app.js') }}"></script>
        <script>
            axios.defaults.headers.common['Authorization'] = 'Bearer {{ $member['api_token'] }}';

            eva.replace();

            $(function () {
                $("#gotop").click(function () {
                    jQuery("html,body").animate({
                        scrollTop: 0
                    }, 1000);
                });
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 300) {
                        $('#gotop').fadeIn("fast");
                    } else {
                        $('#gotop').stop().fadeOut("fast");
                    }
                });
            });

            var toggleLoading = (type) => {
                $('#loading').css('display', type);
            }
        </script>
        @yield('js')
    </body>
</html>
