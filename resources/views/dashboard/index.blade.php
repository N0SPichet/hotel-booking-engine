@extends('dashboard.main')
@section('title', 'Home')

@section('content')
<div class="container dashboard-index">
	<div class="col-md-3 float-left m-t-10">
		@include('layouts.side-tab-dashboard')
	</div>
	<div class="col-md-9 float-left m-t-10">
		<div class="tab-content">
			<div id="menu1" class="tab-pane fade active show in">
				<div class="row m-t-10">
					<div class="col-md-12 text-center">
						<h2 style="text-transform: uppercase;">welcome back {{ Auth::user()->user_fname }}'s</h2>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-md-12 card">
						<div class="card-title">
							<h4>New Rentals</h4>
							@if ($rentals->count())
							<p>You have <span class="badge badge-danger" style="font-size: 15px;">{{$rentals->count()}}</span> new request for booking <a href="{{route('dashboard.rentals.index')}}" class="btn btn-danger">Check</a></p>
							@else
							<p>Congratulations!! You already accept all booking request.</p>
							@endif
						</div>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-md-12 card">
						<div class="card-title">
							<h4>Apartments</h4>
							<div class="col-md-4 float-left text-center">
								<a href="{{ route('apartments.index') }}">
								<b>{{ $apartments->count() }} {{ $apartments->count()>1? 'apartments':'apartment' }} created</b>
								</a>
							</div>
							<div class="col-md-4 float-left text-center">
								<a href="{{ route('dashboard.apartments.online', Auth::user()->id) }}">
								<b>{{ $apartments->where('publish', '1')->count() }} online</b>
								</a>
							</div>
							<div class="col-md-4 float-left text-center">
								<a href="{{ route('dashboard.apartments.offline', Auth::user()->id) }}">
								<b>{{ $apartments->where('publish', '0')->count() }} offline</b>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-md-12 card">
						<div class="card-title">
							<h4>Rooms</h4>
							<div class="col-md-4 float-left text-center">
								<a href="{{ route('rooms.index') }}">
								<b>{{ $rooms->count() }} {{ $rooms->count()>1? 'rooms':'room' }} created</b>
								</a>
							</div>
							<div class="col-md-4 float-left text-center">
								<a href="{{ route('dashboard.rooms.online', Auth::user()->id) }}">
								<b>{{ $rooms->where('publish', '1')->count() }} online</b>
								</a>
							</div>
							<div class="col-md-4 float-left text-center">
								<a href="{{ route('dashboard.rooms.offline', Auth::user()->id) }}">
								<b>{{ $rooms->where('publish', '0')->count() }} offline</b>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="menu5" class="tab-pane fade">
				<a href="{{ route('rentals.rentmyrooms', Auth::user()->id) }}" class="btn btn-info">Manage Rentals</a>
			</div>
		</div>
	</div>
</div>
@endsection
