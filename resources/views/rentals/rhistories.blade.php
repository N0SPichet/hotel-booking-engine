@extends ('main')

@section ('title', 'Rentals | History')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<a href="{{ route('rentals.rmyrooms') }}" class="btn btn-default btn-md"><span class="glyphicon glyphicon-chevron-left"></span>Back to Rentals</a>
		</div>
		<div class="col-md-4">
			<h2 style="color: green;">Approved</h2>
			@foreach ($rentals as $rental)
				@if ($rental->payments->payment_status == 'Approved')
					<a href="{{ route('rentals.show', $rental->id) }}">
						<p>Rent #ID : {{ $rental->id }}</p>
						<p>Rented by : {{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
					</a>
						@if ( $rental->checkin_status == '1' )
							<p>Check in Status : <button class="btn-success">Granted</button></p>
						@elseif ( $rental->checkin_status == '0')
							<p>Check in Status : <button class="btn-warning">Not check in</button></p>
						@endif
					<br>
				@endif
			@endforeach
		</div>

		<div class="col-md-4">
			<h2 style="color: orange;">Cancel</h2>
			@foreach ($rentals as $rental)
				@if ($rental->payments->payment_status == 'Cancel')
					<a href="{{ route('rentals.show', $rental->id) }}">
						<p>Rent #ID : {{ $rental->id }}</p>
						<p>Rented by : {{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
						<p>Status : {{ $rental->payments->payment_status }}</p>
					</a>
					<br>
				@endif
			@endforeach
		</div>

		<div class="col-md-4">
			<h2 style="color: red;">Rejected</h2>
			@foreach ($rentals as $rental)
				@if ($rental->payments->payment_status == 'Reject')
					<a href="{{ route('rentals.show', $rental->id) }}">
						<p>Rent #ID : {{ $rental->id }}</p>
						<p>Rented by : {{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
						<p>Status : {{ $rental->payments->payment_status }}</p>
					</a>
					<br>
				@endif
			@endforeach
		</div>
	</div>
</div>
@endsection