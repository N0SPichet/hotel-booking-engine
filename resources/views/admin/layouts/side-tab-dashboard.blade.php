<ul class="nav flex-column">
	<li class="m-b-20"><h4>System Data</h4></li>
	<li class="nav-item {{route('admin.dashboard')==url()->full()? 'active':''}} {{route('admin.home')==url()->full()? 'active':''}}"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
	<li class="nav-item {{route('admin.apartments.index')==url()->full()? 'active':''}}"><a href="{{route('admin.apartments.index')}}">Apartments</a></li>
	<li class="nav-item {{route('admin.rooms.index')==url()->full()? 'active':''}}"><a href="{{route('admin.rooms.index')}}">Rooms</a></li>
	<li class="nav-item {{route('admin.users.index')==url()->full()? 'active':''}}"><a href="{{route('admin.users.index')}}">Users</a></li>
	<li class="nav-item {{route('admin.users.verify-index')==url()->full()? 'active':''}}"><a href="{{route('admin.users.verify-index')}}">User Verifications</a></li>
	<li class="nav-item {{route('admin.rentals.index')==url()->full()? 'active':''}}"><a href="{{route('admin.rentals.index')}}">Rentals (<span class="{{ $rentals>0?'text-danger':'' }}">{{ $rentals }} new!!</span>)</a></li>
</ul>
<ul class="nav flex-column">
	<li class="m-t-20 m-b-20"><h4>System Component</h4></li>
	<li class="nav-item {{route('comp.categories.index')==url()->full()? 'active':''}}"><a href="{{route('comp.categories.index')}}"><i class="far fa-edit"></i> Categories</a></li>
	<li class="nav-item {{route('comp.tags.index')==url()->full()? 'active':''}}"><a href="{{route('comp.tags.index')}}"><i class="far fa-edit"></i> Tags</a></li>
	<li class="nav-item {{route('comp.amenities.index')==url()->full()? 'active':''}}"><a href="{{route('comp.amenities.index')}}"><i class="far fa-edit"></i> Amenities</a></li>
	<li class="nav-item {{route('comp.details.index')==url()->full()? 'active':''}}"><a href="{{route('comp.details.index')}}"><i class="far fa-edit"></i> Details</a></li>
	<li class="nav-item {{route('comp.rules.index')==url()->full()? 'active':''}}"><a href="{{route('comp.rules.index')}}"><i class="far fa-edit"></i> Rules</a></li>
</ul>
