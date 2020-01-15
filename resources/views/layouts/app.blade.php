<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('custom.websiteName') }}{{ __('custom.admin.browser') }}</title>
    <link rel="apple-touch-icon"  href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('css/admin/material-dashboard.css?v=2.1.1') }}" rel="stylesheet" />
    <style>
        .table-bordered th {
            background: #eee;
            font-weight: bold !important;
            line-height: 20px !important;
        }
        .table-bordered th,
        .table-bordered td {
            line-height: 14px !important;
            font-size: 14px !important;
            border: 1px solid #ddd !important;
            text-align: center;
        }

        .pagination-block {
            margin-top: 20px;
            text-align: center !important;
        }

        .pagination-block nav {
            display: inline-block !important;
        }

        .search-bar {
          margin-bottom: 10px;
          line-height: 51px;
        }

        .search-label {
          line-height: 51px;
        }

        .form-control-selector {
          line-height: 36px;
          padding: 0 15px;
        }

        .search-button-block {
            margin-top: -7px;
        }

        .search-input {
          height: 41px;
          padding: 10px 0 0 5px;
        }

        .btn-search {
            margin-left: 10px;
        }

        .lists-icons {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 3px 5px;
            font-size: 20px;
            cursor: pointer;
        }

        .lists-icon:hover {
            background-color: #ff9800 !important;
        }

        .lists-icons-multi {
            margin-left: 5px;
        }
    </style>
    @stack('css')
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.page_templates.auth')
        @endauth
        @guest()
            @include('layouts.page_templates.guest')
        @endguest


        <!--   Core JS Files   -->
        <script src="{{ asset('js/admin/core/jquery.min.js') }}"></script>
        <script src="{{ asset('js/admin/core/popper.min.js') }}"></script>
        <script src="{{ asset('js/admin/core/bootstrap-material-design.min.js') }}"></script>
        <script src="{{ asset('js/admin/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
        <!-- Plugin for the momentJs  -->
        <script src="{{ asset('js/admin/plugins/moment.min.js') }}"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('js/admin/plugins/sweetalert2.js') }}"></script>
        <!-- Forms Validations Plugin -->
        <script src="{{ asset('js/admin/plugins/jquery.validate.min.js') }}"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="{{ asset('js/admin/plugins/jquery.bootstrap-wizard.js') }}"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="{{ asset('js/admin/plugins/bootstrap-selectpicker.js') }}"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="{{ asset('js/admin/plugins/bootstrap-datetimepicker.min.js') }}"></script>
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="{{ asset('js/admin/plugins/bootstrap-tagsinput.js') }}"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="{{ asset('js/admin/plugins/jasny-bootstrap.min.js') }}"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="{{ asset('js/admin/plugins/fullcalendar.min.js') }}"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="{{ asset('js/admin/plugins/nouislider.min.js') }}"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="{{ asset('js/admin/plugins/arrive.min.js') }}"></script>
        <!-- Chartist JS -->
        <script src="{{ asset('js/admin/plugins/chartist.min.js') }}"></script>
        <!--  Notifications Plugin    -->
        <script src="{{ asset('js/admin/plugins/bootstrap-notify.js') }}"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('js/admin/material-dashboard.js?v=2.1.1') }}" type="text/javascript"></script>
        <script src="{{ asset('js/admin/settings.js') }}"></script>
        @stack('js')
    </body>
</html>