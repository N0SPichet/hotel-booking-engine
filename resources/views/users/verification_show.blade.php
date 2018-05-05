@extends ('main')

@section ('title', 'Verification Details')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<p class="lead">Verification Details</p>
		</div>
		<div class="col-md-8">
			<div class="card">
				<div class="margin-content">
					<div class="col-md-12">
						<label><i class="fas fa-user"></i> Full name</label>
						@if ( $user->user_verifications->title != NULL && $user->user_verifications->name != NULL && $user->user_verifications->lastname != NULL)
						<div class="alert alert-success" role="alert">
						@else
						<div class="alert alert-danger" role="alert" style="height: 50px;">
						@endif
						<p>{{ $user->user_verifications->title }} {{ $user->user_verifications->name }} {{ $user->user_verifications->lastname }}</p>
						</div>

						<label>Gender</label>
						@if ( $user->user_gender != NULL)
						<div class="alert alert-success" role="alert">
						@else
						<div class="alert alert-danger" role="alert" style="height: 50px;">
						@endif
						<p>{{ $user->user_gender }}</p>
						</div>

						<label><i class="far fa-calendar-alt"></i> Join Date</label>
						@if ( $user->created_at != NULL)
						<div class="alert alert-success" role="alert">
						@else
						<div class="alert alert-danger" role="alert" style="height: 50px;">
						@endif
						<p>{{ date('jS F, Y', strtotime($user->created_at)) }}</p>
						</div>

						<label>Address</label>
						@if ( $user->user_address != NULL && $user->user_city != NULL && $user->user_state != NULL &&$user->user_country != NULL )
						<div class="alert alert-success" role="alert">
						@else
						<div class="alert alert-danger" role="alert" style="height: 50px;">
						@endif
						<p>
							@if ($user->user_address != NULL) <span class="text-success"> {{ $user->user_address }} @else <span class="text-danger">null @endif </span>
							@if ($user->user_city != NULL) <span class="text-success"> {{ $user->user_city }} @else <span class="text-danger">null @endif </span>
							@if ($user->user_state != NULL) <span class="text-success"> {{ $user->user_state }}, @else <span class="text-danger">null @endif </span>
							@if ($user->user_country != NULL) <span class="text-success"> {{ $user->user_country }} @else <span class="text-danger">null @endif </span>
						</p>
						</div>
						<label>Confident Document</label>
					</div>
					<div class="col-md-12">
						<p><a href="{{ asset('images/verification/id_card/' . $user->id . '/'.$user->user_verifications->id_card) }}" target="_blank"><span class="text-primary">ID Card</span></a></p>
						<p><a href="{{ asset('images/verification/census_registration/' . $user->id.'/'. $user->user_verifications->census_registration) }}" target="_blank"><span class="text-primary">Census Registration</span></a></p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="well" align="center">
				@if (Auth::check())
					@if (Auth::user()->level == '0')
						<p class="text-primary">Admin Decision</p>
						@if ($user->user_verifications->verify != '1' && $user->user_verifications->verify != '2')
						{!! Form::open(['route' => ['user.verify-approve', $user->id]]) !!}
							<button type="submit" class="btn btn-primary btn-sm" style="width: 60%"><i class="far fa-check-circle"></i> Verify</button>
						{!! Form::close() !!}
						{!! Form::open(['route' => ['user.verify-reject', $user->id]]) !!}
							<button type="submit" class="btn btn-danger btn-sm margin-top-10" style="width: 60%"><i class="far fa-times-circle"></i> Reject</button>
						{!! Form::close() !!}
						@elseif ($user->user_verifications->verify == '1')
							<p class="text-success"><i class="fas fa-check"></i> Confirm</p>
						@elseif ($user->user_verifications->verify == '2')
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
	<script type="text/javascript">

		$(document).ready(function() {

			/* This is basic - uses default settings */
			
			$("a#single_image").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	200, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
			});
			
			/* Using custom settings */
			
			$("a#inline").fancybox({
				'hideOnContentClick': true
			});

			/* Apply fancybox to multiple items */
			
			$("a.group").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
			});
			
		});
	</script>
@endsection