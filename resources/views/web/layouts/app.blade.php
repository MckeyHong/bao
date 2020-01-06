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
            padding-top: 55px;
            position: fixed;
            width: 100%;
            height: 120px;
            z-index: 99;
        }

        .menu-block {
            margin: 8px auto;
            text-align: center;
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

        .loading-modal {
            margin-top: 50%;
            background: transparent;
            border: 0;
        }
        </style>
        <script src="{{ asset('js/vendor/eva.min.js') }}"></script>
    </head>
    <body>
        <div id="app">
            @include('web.layouts.header')
            @include('web.layouts.menu')
            <div  class="container-fluid">
                @yield('content')
            </div>
            @include('web.layouts.footer')
        </div>
        <div id="loadingModal" tabindex="-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content loading-modal">
              <img src="{{ asset('images/loading.svg') }}">
            </div>
          </div>
        </div>

        <script src="{{ mix('/js/app.js') }}"></script>
        <script>
            eva.replace()
        </script>
        @yield('js')
    </body>
</html>
