@extends ('main')

@section ('title', 'Rentals')

@section ('content')
<div class="container">
	<div class="row">

		<div class="col-md-4 col-md-offset-0">
			<h1>Check in Code</h1>
			{{ Form::open(array('route' => 'checkin.code')) }}
				{{ Form::label('rent_id', 'Rent id') }}
				{{ Form::text('rent_id', null, array('class' => 'form-control')) }}

				{{ Form::label('checkin_code', 'Code here') }}
				{{ Form::text('checkin_code', null, array('class' => 'form-control')) }}

				{{ Form::submit('Check in', array('class' => 'btn btn-success btn-md btn-h1-spacing')) }}
			{{ Form::close() }}
		</div>

		<div class="col-md-4 col-md-offset-0">
			<h1>New rental</h1>
			<label>Room</label>
			@foreach ($houses as $house)
				<button class="btn btn-default btn-block form-spacing-top-8" type="button" data-toggle="collapse" data-target="#{{ $house->id }}" aria-expanded="true">
					{{ $house->house_title }}
				</button>
				<div class="collapse" id="{{ $house->id }}">
					<div class="card card-block">
					@foreach ($rentals as $rental)
						@if ($rental->houses_id == $house->id)
							@if ($rental->payments->payment_status == 'Waiting')
								<a href="{{ route('rentals.show', $rental->id) }}">
									<p>Rent #ID : {{ $rental->id }}</p>
									<p>Rented by :{{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
									<p>Status : {{ $rental->payments->payment_status }}</p>
								</a>
							@endif
						@endif
					@endforeach
					</div>
				</div>
			@endforeach
		</div>

		<div class="col-md-4 col-md-offset-0">
			<h1>History</h1>
			@foreach ($houses as $house)
				@foreach ($rentals as $rental)
					@if ($rental->houses_id == $house->id)
						@if ($rental->payments->payment_status != 'Waiting')
							<a href="{{ route('rentals.show', $rental->id) }}">
								<p>Rent #ID : {{ $rental->id }}</p>
								<p>Rent by :{{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
								<p>Status : {{ $rental->payments->payment_status }}</p>

								@if ($rental->payments->payment_status != 'Reject')
								<p>Check in status :
									@if ( $rental->checkin_status == '1')
										granted
									@else
										Not check in now
									@endif
								</p>
								@endif

							</a>
							<br>
							<br>
						@endif
					@endif
				@endforeach
			@endforeach

		</div>

	</div> <!-- end of col-md-12 row-->
</div>
@endsection