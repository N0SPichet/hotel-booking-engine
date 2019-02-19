<!DOCTYPE html>
<html lang="en">
  <head>
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- tep icon-->
    <link rel="shortcut icon" href="https://cdn1.iconfinder.com/data/icons/hotel-restaurant/512/1-512.png">

    <!-- Required meta tags -->
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Styles -->
    @yield('stylesheets')
    {{ Html::style('css/styles.css') }}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- old -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- new -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css">
    
  </head>
<body style="background-color: #D8D8D8;">
  <nav class="navbar navbar-expand-sm navbar-expand-md navbar-toggleable-sm">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('home') }}">Love To Travel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ Request::is('/') ? 'active'  : ''}}">
          <a class="nav-link navbar-link-spacing" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item {{ Request::is('diaries') ? 'active'  : ''}}">
          <a class="nav-link navbar-link-spacing" href="{{ route('diaries.index') }}"><i class="fas fa-users"></i> Diaries</a>
        </li>
        @if (Auth::guest())
        <li class="nav-item {{ Request::is('helps') ? 'active'  : ''}}">
          <a class="nav-link navbar-link-spacing" href="{{ route('helps.index') }}" ><i class="far fa-question-circle"></i> Help</a>
        </li>
        @endif
        <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input class="form-control mr-sm-2 navbar-link-spacing" type="search" placeholder="Phuket..." aria-label="Search" name="search">
        </form>
      </ul>
      <ul class="navbar-nav navbar-right">
        @if (Auth::guest())
          <li class="nav-item"><a class="nav-link navbar-link-spacing" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
          <li class="nav-item"><a class="nav-link navbar-link-spacing" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a></li>
        @else
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-flag"></i> Hosting
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a  class="dropdown-item" href="{{ route('hosts.introroom') }}"><i class="fas fa-home"></i> Room</a>
            <a class="dropdown-item" href="{{ route('hosts.introapartment') }}"><i class="far fa-building"></i> Apartment</a>
            <a class="dropdown-item" href="{{ route('rentals.rmyrooms') }}"><i class="far fa-envelope"></i> Manage</a>
          </div>
        </li>
        <li class="nav-item {{ Request::is('mytrips') ? 'active'  : ''}}">
          <a class="nav-link navbar-link-spacing" href="{{ route('mytrips') }}"><i class="fas fa-suitcase"></i> Trips</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span>
            @if (Auth::user()->user_image == NULL)
              <img src="{{ asset('images/users/blank-profile-picture.png') }}" class="rounded-circle" style="width: 32px; height: 32px;">
            @else
              <img src="{{ asset('images/users/'. Auth::user()->id . '/' . Auth::user()->user_image) }}" class="rounded-circle" style="width: 32px; height: 32px;">
            @endif
            </span>
            {{ Auth::user()->user_fname }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('users.profile') }}"><i class="far fa-user"></i> My Profile</a>
            <a class="dropdown-item" href="{{ route('diaries.mydiaries') }}"><i class="fas fa-book"></i> My Memories</a>
            <a class="dropdown-item" href="{{ route('summary') }}"><i class="fas fa-chart-line"></i> Summary</a>
            @if (Auth::user()->hasRole('Admin'))
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('user.verify-index') }}"><i class="far fa-check-circle"></i> User Verification</a>
            <a class="dropdown-item" href="{{ route('users.index') }}"><i class="fas fa-list-ul"></i> All Users</a>
            <a class="dropdown-item" href="{{ route('rooms.index') }}"><i class="fas fa-list-ul"></i> All Rooms</a>
            <a class="dropdown-item" href="{{ route('rentals.index') }}"><i class="fas fa-list-ul"></i> All Trips</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('categories.index') }}"><i class="far fa-edit"></i> Categories</a>
            <a class="dropdown-item" href="{{ route('tags.index') }}"><i class="far fa-edit"></i> Diary Tags</a>
            <a class="dropdown-item" href="{{ route('houseamenities.index') }}"><i class="far fa-edit"></i> Room Amenities</a>
            <div class="dropdown-divider"></div>
            @endif
            <a class="dropdown-item" href="{{ route('helps.index') }}" ><i class="far fa-question-circle"></i> Help</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
          </div>
        </li>
        @endif
      </ul>
    </div>
  </nav>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

@include('pages._messages')

@yield('content')

{!! Html::script('js/parsley.min.js') !!}
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<!-- new -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- new -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.collapsible/1.2/jquery.collapsible.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpapamqxDakm2fQBWzujijdyfQfMDUbxo&libraries=places"></script>
@yield ('scripts')

@include('pages._footer')
</body>
</html>
