<ul class="nav flex-column">
	<li class="nav-item {{route('dashboard.index')==url()->full()? 'active':''}}"><a href="{{route('dashboard.index')}}">Dashboard</a></li>
	<li class="nav-item {{route('dashboard.diaries.index')==url()->full()? 'active':''}}"><a href="{{route('dashboard.diaries.index')}}">Diaries</a></li>
	<li class="nav-item {{route('dashboard.trips.index')==url()->full()? 'active':''}}"><a href="{{route('dashboard.trips.index')}}">Trips</a></li>
	<li class="nav-item {{route('dashboard.hosts.index')==url()->full()? 'active':''}}"><a href="{{route('dashboard.hosts.index')}}">Hosting</a></li>
	<li class="nav-item {{route('dashboard.rentals.index')==url()->full()? 'active':''}}"><a href="{{route('dashboard.rentals.index')}}">Manage Rentals</a></li>
	<li class="nav-item {{route('dashboard.summary.index')==url()->full()? 'active':''}}"><a href="{{route('dashboard.summary.index')}}">Rentals Summary</a></li>
	<li class="nav-item {{route('dashboard.account.index')==url()->full()? 'active':''}}"><a href="{{route('dashboard.account.index')}}">Account</a></li>
</ul>
