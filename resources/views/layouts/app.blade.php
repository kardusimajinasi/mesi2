<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MESI</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Bootstrap 4.6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

    <!-- full kalender -->
    <link rel="stylesheet" href="{{asset('plugins/fullcalendar/main.min.css')}}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom CSS for alignment -->
    <style>
        .dataTables_length label {
            margin-right: 1rem;
        }
        .dataTables_paginate {
            float: right;
        }
        .dataTables_wrapper .dataTables_info {
            float: left;
            margin-top: 0.85rem;
        }
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 0.85rem;
        }
    </style>

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('stylesheets/adminlte.min.css')}}">


    {{-- favicon --}}
    <link rel="icon" href="{{ url('images/logo.png') }}">
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('layouts.navbar')
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('layouts.aside')
        </aside>

        <div class="content-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>

        <footer class="main-footer">
            @include('layouts.footer')
        </footer>
    </div>

    <!-- jQuery 3.6.0 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- InputMask -->
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>

    {{-- full kalender --}}
    <script src="{{asset('plugins/fullcalendar/main.min.js')}}"></script>

    <!-- date-range-picker -->
    <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <!-- Select2 -->
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>

    <!-- Bootstrap 4.6 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <!-- AdminLTE App -->
    <script src="{{asset('javascripts/adminlte.min.js')}}"></script>

    <!-- Your custom scripts -->
    @stack('scripts')
</body>
</html>
