@extends ('admin.layouts.app')
@section ('title', $user->user_fname . ' Profile')

@section ('content')
<div class="container users">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Users</a>
		</div>
	</div>
	<div class="m-t-10">
		<div class="card">
			<div class="card-header">
				@if ($user->user_image == null)
				<img src="{{ asset('images/users/blank-profile-picture.png') }}" alt="profile" class="profile-img">
				@else
				<img src="{{ asset('images/users/'. $user->id. '/' . $user->user_image) }}" alt="profile" class="profile-img">
				@endif
			</div>
			<div class="card-body">
				<p class="full-name">{{ $user->user_fname }} {{ $user->user_lname }} @if ($user->verification->verify === '1') <small style="color: green; text-transform: lowercase;"><i class="far fa-check-circle"></i>verifired</small> @endif</p>
				<p class="username" style="text-transform: lowercase;"><a href="{{ route('admin.users.show', "@".$user->user_fname."_".substr($user->user_lname, 0, 3)) }}">{{ "@".$user->user_fname."_".substr($user->user_lname, 0, 3) }}</a></p>
				@if ($user->district_id != null || $user->province_id != null)
				<p class="address">{{ $user->district->name }}, {{ $user->province->name }}</p>
				@endif
				@if ($user->user_description != null)
				<span class="description">{!! $user->user_description !!}</span>
				@endif
				<div class="col-md-6 float-left m-t-10">
					<p class="full-name">Hosting List</p>
					@if (count($user->houses))
					@foreach ($user->houses as $house)
						<a href="{{ route('admin.rooms.as-owner', $house->id) }}">
							<div align="left">
								<p>Title : {{ $house->house_title }} - {{ $house->district->name }}, {{ $house->province->name }} <span class="room-rating">( rating @if ($house->rentals->count()>0) {{ ($house->rentals->where('checkin_status', '1')->count()/$house->rentals->count()) * 100 }} @else 0 @endif %)</span></p>
							</div>
						</a>
					@endforeach
					@else
					<p>No result</p>
					@endif
				</div>
				<div class="col-md-6 float-left m-t-10">
					<p class="full-name">{{ $user->user_fname }} has review</p>
					@if (!$user->reviews->isEmpty())
					@foreach ($user->reviews as $key => $review)
					<p class="m-t-10">Stay at <a target="_blank" href="{{ route('rooms.show', $review->house_id) }}">{{ $review->house->house_title }}</a> ({{ $review->created_at->diffForHumans() }})</p>
					{!! $review->comment !!}
					@endforeach
					@else
					<p>No review</p>
					@endif
				</div>
			</div>
			<div class="card-footer">
				<div class="col-6 float-left">
					<p><span class="count">{{ $user->followers($user->id) }}</span> Followers</p>
				</div>
				<div class="col-6 float-left">
					<p><span class="count">{{ $user->following($user->id) }}</span> Following</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/main.js') }}" defer></script>
@endsection
