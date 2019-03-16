@extends ('dashboard.main')
@section ('title', $user->user_fname . ' ' . 'Profile')

@section ('content')
<div class="container users">
	<div class="row m-t-10">
		<div class="card col-12">
			<div class="card-header">
				@if ($user->user_image == null)
				<img src="{{ asset('images/users/blank-profile-picture.png') }}" alt="profile" class="profile-img">
				@else
				<img src="{{ asset('images/users/'. $user->id. '/' . $user->user_image) }}" alt="profile" class="profile-img">
				@endif
			</div>
			<div class="card-body">
				<h1>{{ Auth::user()->user_fname }}'s Account @if (Auth::user()->verification->verify === '1') <small class="text-success"><i class="far fa-check-circle"></i> verifired</small> @else <small class="text-danger"><a href="{{ route('users.verify-user', Auth::user()->id) }}" class="btn btn-outline-danger"><i class="fa fa-exclamation-circle"></i> unverify</a></small>@endif</h1>
				@if ($user->verification->passport != null)
				<div class="col-md-12">
					<p>your passport : <b class="text-danger">{{ substr($user->verification->passport, 9, 3) }}{{ substr($user->verification->passport, 15, 3) }}{{ substr($user->verification->passport, 12, 3) }}</b> keep it's secret</p>
					<p>your secret : <b class="text-danger">{{ $user->verification->secret }}</b> keep it's secret</p>
					<p>passport code you can use to identify yourself when checkin. please keep it's secret and don't tell anyone or hosts that you has rent their's home.</p>
				</div>
				@endif
				<div class="col-md-4 col-sm-4 float-left" align="center">
					<p class="full-name">{{ $user->user_fname }} {{ $user->user_lname }}</p>
					<p class="username" style="text-transform: lowercase;"><a href="{{ route('users.show', "@".$user->user_fname."_".substr($user->user_lname, 0, 3)) }}">{{ "@".$user->user_fname."_".substr($user->user_lname, 0, 3) }}</a></p>
					@if ($user->district_id != null || $user->province_id != null)
					<p class="address">{{ $user->district->name }}, {{ $user->province->name }}</p>
					@endif
					@if ($user->user_description != null)
					<span class="description">{!! $user->user_description !!}</span>
					@endif
					<div>
						<p class="text-danger full-name">Private details</p>
						@if ($user->user_tel != null)
						<p>tel {{ $user->user_tel }}</p>
						@endif
						@if ($user->email != null)
						<p>email <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
						@endif
						@if ($user->user_gender != null)
						<p>gender <span id="gender">{{ $user->user_gender }}</span></p>
						@endif
					</div>
				</div>
				<div class="col-md-8 col-sm-8 float-left">
					<p class="full-name">Hosting List ({{count($user->houses)}} public)</p>
					@if (count($user->houses))
					@foreach ($user->houses as $house)
						<a href="{{ route('rooms.owner', $house->id) }}">
							<p>Title : {{ $house->house_title }} - {{ $house->district->name }}, {{ $house->province->name }} <span class="room-rating">( rating @if ($house->rentals->count()>0) {{ ($house->rentals->where('checkin_status', '1')->count()/$house->rentals->count()) * 100 }} @else 0 @endif %)</span></p>
						</a>
					@endforeach
					@else
					<p>No result</p>
					@endif
				</div>
			</div>
		</div>
		<div class="card col-12 m-t-10">
			<div class="margin-content">
				<div class="col-md-3 col-sm-3 float-left">
					{!! Html::linkRoute('dashboard.account.index', 'Update', null, array('class' => 'btn btn-info btn-block m-t-10')) !!}
				</div>

				<div class="col-md-3 col-sm-3 float-left">
					{!! Html::linkRoute('rentals.mytrips', 'My Trips', array($user->id), array('class' => 'btn btn-info btn-block m-t-10')) !!}
				</div>

				<div class="col-md-3 col-sm-3 float-left">
					{!! Html::linkRoute('diaries.mydiaries', 'My Diaries', array($user->id), array('class' => 'btn btn-info btn-block m-t-10')) !!}
				</div>

				<div class="col-md-3 col-sm-3 float-left">
					{!! Html::linkRoute('users.description', 'About My Self', array($user->id), array('class' => 'btn btn-info btn-block m-t-10')) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/main.js') }}" defer></script>
@endsection
