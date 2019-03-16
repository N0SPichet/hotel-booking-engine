<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title') | Admin | Love to Travel</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    {{ Html::style('css/styles.css') }}
</head>
<body>
    <div id="app">
        @include('admin.layouts.nav-bar')
        @include('pages._messages')
        <div class="clearfix m-b-20">
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{-- <script src="https://use.fontawesome.com/releases/v5.0.6/js/all.js" defer></script> --}}
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js" integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous"></script>
    {{-- google map --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpapamqxDakm2fQBWzujijdyfQfMDUbxo&libraries=places"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.footer').addClass('manage');
        });
    </script>
    @yield('scripts')
</body>
</html>
