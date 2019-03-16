<header class="clear-both manage">
	<div class="wrapper">
		<a href="{{ route('admin.home') }}"><h1 class="logo">Love To Travel</h1></a>
		<nav>
			<h2>Main Navigation</h2>
			<ul>
				@guest('admin')
			    <li><a href="{{ route('admin.auth.login') }}">Login</a></li>
			    <li><a href="{{ route('admin.register') }}">Register</a></li>
				@else
				<li>
					<a href="#">{{ Auth::user()->name }} <span class="caret"></span></a>
					<ul class="hav-sub-nav">
						<li><a href="{{ route('admin.auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    	<form id="logout-form" action="{{ route('admin.auth.logout') }}" method="POST" style="display: none;">
                        	{{ csrf_field() }}
                    	</form>
					</ul>
				</li>
				@endguest
			</ul>
		</nav>
	</div>
</header>
