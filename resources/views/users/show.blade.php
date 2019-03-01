@extends ('main')
@section ('title', $user->user_fname . ' Profile')
@section ('content')
<div class="container">
	@if (Auth::user()->hasRole('Admin'))
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Users</a>
		</div>
	</div>
	@endif
	<div class="row m-t-10">
		<div class="col-md-12">
			<div align="center">
				<p class="lead">{{ $user->user_fname }} Profile @if ($user->verification->verify === '1') <small style="color: green;"><i class="far fa-check-circle"></i>verifired</small> @endif</p>
				@if ($user->user_image == null)
				<img src="{{ asset('images/users/blank-profile-picture.png') }}" class="rounded-circle" style="width:200px; height: 200px; ">
				@else
				<img src="{{ asset('images/users/'. $user->id. '/' . $user->user_image) }}" class="rounded-circle" style="width:200px; height: 200px;">
				@endif
			</div>
		</div>
	</div>
	<div class="row m-t-20">
		<div class="col-md-8 float-left">
			<div class="card margin-content">
				<p><b>Name </b>{{ $user->user_fname }}</p>
				<p><b>Last Name </b>{{ $user->user_lname }}</p>
				<p><b>Gender </b>{{ $user->user_gender }}</p>
				@if($user->district_id !== null || $user->province_id !== null)
				<p><b>District </b>{{ $user->district->name }}</p>
				<p><b>Province</b>{{ $user->province->name }}</p>
				@endif
				<p><b>Description </b>{!! $user->user_description !!}</p>
				<p><b>Rating </b>{{ $user->user_score }}</p>
				<p><b>Join Date</b>{{ date('jS F, Y', strtotime($user->created_at)) }}</p>
			</div>
		</div>

		<div class="col-md-4 float-left">
			<p class="lead">Hosting List</p>
			@if (Auth::check())
			@if (Auth::user()->id == $user->id || Auth::user()->hasRole('Admin'))
			@foreach ($houses as $house)
				<a href="{{ route('rooms.owner', $house->id) }}" class="btn btn-outline-secondary btn-md btn-block">
					<div align="left">
						<p>Title : {{ $house->house_title }}</p>
						<p>Last update : {{ date("jS F, Y", strtotime($house->updated_at)) }}</p>
					</div>
				</a>
			@endforeach
			@else
			@foreach ($houses as $house)
				@if($house->checkType($house->id))
				<a href="{{ route('rooms.show', $house->id) }}" class="btn btn-outline-info btn-sm btn-block">
					<h4>{{ $house->house_title }}</h4>
				</a>
				@else
				<a href="{{ route('apartments.show', $house->id) }}" class="btn btn-outline-info btn-sm btn-block">
					<h4>{{ $house->house_title }}</h4>
				</a>
				@endif
			@endforeach
			@endif
			@endif
		</div>
	</div>
</div>
@endsection