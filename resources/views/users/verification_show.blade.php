@extends ('main')

@section ('title', 'Verification Details')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-12">
			<p class="lead">Verification Details</p>
			<a href="{{ route('users.verify-index') }}" class="btn btn-info">Back</a>
			<hr>
		</div>
		<div class="col-md-8 float-left">
			<div class="card">
				<div class="margin-content">
					<div class="col-md-12">
						<label><i class="fas fa-user"></i> Full name</label>
						@if ( $user->verification->title != null && $user->verification->name != null && $user->verification->lastname != null)
						<div class="alert alert-success" role="alert">
						@else
						<div class="alert alert-danger" role="alert" style="height: 50px;">
						@endif
						<p>{{ $user->verification->title }} {{ $user->verification->name }} {{ $user->verification->lastname }}</p>
						</div>

						<label>Gender</label>
						@if ( $user->user_gender != null)
						<div class="alert alert-success" role="alert">
						@else
						<div class="alert alert-danger" role="alert" style="height: 50px;">
						@endif
						<p id="gender">{{ $user->user_gender }}</p>
						</div>

						<label><i class="far fa-calendar-alt"></i> Join Date</label>
						@if ( $user->created_at != null)
						<div class="alert alert-success" role="alert">
						@else
						<div class="alert alert-danger" role="alert" style="height: 50px;">
						@endif
						<p>{{ date('jS F, Y', strtotime($user->created_at)) }}</p>
						</div>

						<label>Address</label>
						@if ( $user->user_address != null && $user->sub_district_id != null && $user->district_id != null &&$user->province_id != null )
						<div class="alert alert-success" role="alert">
						@else
						<div class="alert alert-danger" role="alert" style="height: 50px;">
						@endif
						<p>
							@if ($user->user_address != null) <span class="text-success"> {{ $user->user_address }} @else <span class="text-danger">no-info @endif </span>
							@if ($user->sub_district_id != null) <span class="text-success"> {{ $user->sub_district->name }} @else <span class="text-danger">no-info @endif </span>
							@if ($user->district_id != null) <span class="text-success"> {{ $user->district->name }}, @else <span class="text-danger">no-info @endif </span>
							@if ($user->province_id != null) <span class="text-success"> {{ $user->province->name }} @else <span class="text-danger">no-info @endif </span>
						</p>
						</div>
						<label>Confident Document</label>
					</div>
					<div class="col-md-12">
						@if($user->verification->id_card)
						<p><a href="{{ asset('images/verifications/' . $user->id . '/'.$user->verification->id_card) }}" target="_blank"><span class="text-primary">ID Card</span></a></p>
						@endif
						@if($user->verification->census_registration)
						<p><a href="{{ asset('images/verifications/' . $user->id.'/'. $user->verification->census_registration) }}" target="_blank"><span class="text-primary">Census Registration</span></a></p>
						@endif
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4 float-left">
			<div class="well" align="center">
				@if (Auth::check())
					@if (Auth::user()->hasRole('Admin'))
						<p class="text-primary">Admin Decision</p>
						@if ($user->verification->verify != '1' && $user->verification->verify != '2')
						{!! Form::open(['route' => ['users.verify-approve', $user->id]]) !!}
							<button type="submit" class="btn btn-primary btn-sm" style="width: 60%"><i class="far fa-check-circle"></i> Verify</button>
						{!! Form::close() !!}
						{!! Form::open(['route' => ['users.verify-reject', $user->id]]) !!}
							<button type="submit" class="btn btn-danger btn-sm m-t-10" style="width: 60%"><i class="far fa-times-circle"></i> Reject</button>
						{!! Form::close() !!}
						@elseif ($user->verification->verify == '1')
							<p class="text-success"><i class="fas fa-check"></i> Confirm</p>
						@elseif ($user->verification->verify == '2')
							<p class="text-danger"><i class="fas fa-check"></i> Reject</p>
						@endif
					@endif
				@endif
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/main.js') }}" defer></script>
@endsection
