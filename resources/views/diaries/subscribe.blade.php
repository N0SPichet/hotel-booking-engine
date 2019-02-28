@extends ('main')

@section ('title', 'Subscribe')

@section ('content')

	<div class="container">
		<div class="row">
			<h2 class="title-page">Follow {{ $diary->user->user_fname }}</h2>

			<div class="col-md-12 col-sm-12">
				<div class="col-md-10">
					<p style="font-size: 18px;">Following to <span style="text-transform: lowercase;">{{ $diary->user->user_fname }}</span> and get an access to diary that <span style="text-transform: lowercase;">{{ $diary->user->user_fname }}</span> have shared in public and follower.</p>
				</div>
				<div class="col-md-2">
					{!! Form::open(['route'=> ['diaries.subscribe', $diary->user_id]]) !!}
					<button class="btn btn-danger form-spacing-top-8 poll-right">Follow {{ $diary->user->user_fname }}</button>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

@endsection
