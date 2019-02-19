@extends ('main')

@section ('title', $user->user_fname . ' Profile')

@section ('content')
<div class="container">
	<div class="row">
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
	<div class="row">
		<div class="col-md-8">
			<dl class="dl-horizontal">
				<dt>Name</dt>
				<dd>{{ $user->user_fname }}</dd>

				<dt>Last Name</dt>
				<dd>{{ $user->user_lname }}</dd>

				<dt>Gender</dt>
				<dd>{{ $user->user_gender }}</dd>

				<dt>State / Province</dt>
				<dd>{{ $user->user_state }}</dd>

				<dt>Country</dt>
				<dd>{{ $user->user_country }}</dd>

				<dt><a href="{{ route('users.description', $user->id) }}" class="btn btn-outline-info">Description</a></dt>
				<dd>{!! $user->user_description !!}</dd>

				<dt>Rating</dt>
				<dd>{{ $user->user_score }}</dd>

				<dt>Join Date</dt>
				<dd>{{ date('jS F, Y', strtotime($user->created_at)) }}</dd>
			</dl>
		</div>

		<div class="col-md-4">
			<p class="lead">Hosting List</p>
			@if (Auth::check())
			@if (Auth::user()->id == $user->id)
			@foreach ($houses as $house)
				<a href="{{ route('rooms.single', $house->id) }}" class="btn btn-outline-success btn-md btn-block">
					<div align="left">
						<p>Title : {{ $house->house_title }}</p>
						<p>Last update : {{ date("jS F, Y", strtotime($house->updated_at)) }}</p>
					</div>
				</a>
			@endforeach
			@else
			@foreach ($houses as $house)
				<a href="{{ route('rooms.show', $house->id) }}" class="btn btn-outline-success btn-md btn-block">
					<p>{{ $house->house_title }}</p>
					<p>Last update : {{ date("jS F, Y", strtotime($house->updated_at)) }}</p>
				</a>
			@endforeach
			@endif
			@endif
		</div>
	</div>

	<div class="row">
		@if (Auth::check())
		@if (Auth::user()->level == '0')
		<div class="col-sm-6">
			<a href="{{ route('users.index') }}" class="btn btn-link btn-md">Back</a>
		</div>
		@endif
		@endif
	</div>
</div>
@endsection