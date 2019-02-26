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
                    <a class="dropdown-item" href="{{ route('users.profile', Auth::user()->id) }}"><i class="far fa-user"></i> My Profile</a>
                    <a class="dropdown-item" href="{{ route('diaries.mydiaries') }}"><i class="fas fa-book"></i> My Memories</a>
                    <a class="dropdown-item" href="{{ route('summary') }}"><i class="fas fa-chart-line"></i> Summary</a>
                    @if (Auth::user()->hasRole('Admin'))
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('users.verify-index') }}"><i class="far fa-check-circle"></i> User Verification</a>
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