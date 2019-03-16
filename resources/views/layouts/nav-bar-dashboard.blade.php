<header class="clear-both manage">
	<div class="wrapper">
		<a href="{{ route('home') }}"><h1 class="logo">Love To Travel</h1></a>
		<nav>
			<h2>Main Navigation</h2>
			<ul>
				<li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
				<li><a href="{{ route('rentals.mytrips', Auth::user()->id) }}">Trips</a></li>
				<li>
					<a href="#">{{ Auth::user()->user_fname }} Account <i class="material-icons">keyboard_arrow_down</i></a>
					<ul class="hav-sub-nav">
						<li><a href="{{ route('users.profile', Auth::user()->id) }}">Profile</a></li>
						<li><a href="{{ route('diaries.mydiaries', Auth::user()->id) }}">My Diaries</a></li>
						<li><a href="{{ route('helps.index') }}">Help</a></li>
						<li class="dropdown-divider"></li>
						<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        	{{ csrf_field() }}
                    	</form>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
</header>
