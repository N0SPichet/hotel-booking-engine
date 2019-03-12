<!DOCTYPE html>
<html lang="en">
  <head>
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="https://cdn1.iconfinder.com/data/icons/hotel-restaurant/512/1-512.png">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('stylesheets')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css">
    {{ Html::style('css/styles.css') }}
  </head>
  <body>
    @include('layouts.nav-bar')
    @include('pages._messages')
    <div class="clearfix m-b-20">
        @yield('content')
    </div>
    @include('layouts.footer')
    {{-- form --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://use.fontawesome.com/releases/v5.0.6/js/all.js" defer></script>
    {{-- bootstrap --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    {{-- jquery --}}
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js" defer></script>
    {{-- google map --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpapamqxDakm2fQBWzujijdyfQfMDUbxo&libraries=places"></script>
    @yield ('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.footer').removeClass('manage');
        });
    </script>
  </body>
</html>
