<header class="clear-both">
	<div class="wrapper">
		<a href="{{ route('home') }}"><h1 class="logo">Love To Travel</h1></a>
		<nav>
			<h2>Main Navigation</h2>
			<ul>
				<li><a href="{{ route('home') }}">Home</a></li>
				<li><a href="{{ route('diaries.index') }}">Diaries</a></li>
				<li><a href="{{ route('helps.index') }}">Help</a></li>
				@if(Auth::guest())
				<li><a href="{{ route('login') }}">Login</a></li>
				<li><a href="{{ route('register') }}">Register</a></li>
				@else
				<li>
					<a href="#">Hosting<i class="material-icons">keyboard_arrow_down</i></a>
					<ul class="hav-sub-nav">
						<li><a href="{{ route('hosts.introroom') }}">Room</a></li>
						<li><a href="{{ route('hosts.introapartment') }}">Apartment</a></li>
						<li><a href="{{ route('rentals.rentmyrooms', Auth::user()->id) }}">Manage</a></li>
					</ul>
				</li>
				<li><a href="{{ route('rentals.mytrips', Auth::user()->id) }}">Trips</a></li>
				@if (Auth::user()->hasRole('Admin'))
				<li>
					<a href="#">Admin <i class="material-icons">keyboard_arrow_down</i></a>
					<ul class="hav-sub-nav">
						<li><a href="{{ route('users.verify-index') }}">User Verifications</a></li>
						<li><a href="{{ route('apartments.index') }}">Apartments</a></li>
						<li><a href="{{ route('rooms.index') }}">Rooms</a></li>
						<li><a href="{{ route('users.index') }}">Users</a></li>
						<li><a href="{{ route('rentals.index') }}">Trips</a></li>
					</ul>
				</li>
				<li>
					<a href="#">Components <i class="material-icons">keyboard_arrow_down</i></a>
					<ul class="hav-sub-nav">
						<li class="text-center">Diary Comp</li>
						<li><a href="{{ route('comp.categories.index') }}"><i class="far fa-edit"></i>Categories</a></li>
						<li><a href="{{ route('comp.tags.index') }}"><i class="far fa-edit"></i>Tags</a></li>
						<li class="text-center">Room Comp</li>
						<li><a href="{{ route('comp.amenities.index') }}"><i class="far fa-edit"></i>Amenities</a></li>
						<li><a href="{{ route('comp.details.index') }}"><i class="far fa-edit"></i>Details</a></li>
						<li><a href="{{ route('comp.rules.index') }}"><i class="far fa-edit"></i>Rules</a></li>
					</ul>
				</li>
				@endif
				<li>
					<a href="#">{{ Auth::user()->user_fname }} Account <i class="material-icons">keyboard_arrow_down</i></a>
					<ul class="hav-sub-nav">
						<li><a href="{{ route('users.profile', Auth::user()->id) }}">Profile</a></li>
						<li><a href="{{ route('diaries.mydiaries', Auth::user()->id) }}">My Diaries</a></li>
						<li><a href="{{ route('summary') }}">Rental Summary</a></li>
						<li><a href="{{ route('helps.index') }}">Help</a></li>
						<li class="dropdown-divider"></li>
						<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        	{{ csrf_field() }}
                    	</form>
					</ul>
				</li>
				@endif
			</ul>
		</nav>
	</div>
</header>
