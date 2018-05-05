@extends ('main')

@section ('title', 'Rentals | History')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<a href="{{ route('rentals.rmyrooms') }}" class="btn btn-outline-secondary"> Back to Rentals</a>
		</div>
		<div class="col-md-4">
			<div class="w3-card-4 margin-top-10">
				<h2 class="text-success margin-content">Approved</h2>
				@foreach ($rentals_approved as $rental)
				<div class="card margin-top-10">
					<div class="margin-content">
						<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
							<p>Date : {{ date('jS F, Y', strtotime($rental->created_at)) }}</p>
							<p>Rented by : {{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
						</a>
						@if ( $rental->checkin_status == '1' )
						<p>Check in Status : <button class="btn-success">Granted</button></p>
						@elseif ( $rental->checkin_status == '0')
						<p>Check in Status : <button class="btn-warning">Not check in</button></p>
						@endif
					</div>
				</div>
				@endforeach
			</div>
		</div>

		<div class="col-md-4">
			<div class="w3-card-4 margin-top-10">
				<h2 class="text-danger margin-content">Rejected</h2>
				@foreach ($rentals as $rental)
				@if ($rental->payments->payment_status == 'Reject' || $rental->host_decision == 'REJECT')
				<div class="card margin-top-10">
					<div class="margin-content">
						<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
							<p>Date : {{ date('jS F, Y', strtotime($rental->created_at)) }}</p>
							<p>Rented by : {{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
						</a>
					</div>
				</div>
				@endif
				@endforeach
			</div>
		</div>

		<div class="col-md-4">
			<div class="w3-card-4 margin-top-10">
				<h2 class="text-warning margin-content">Cancel</h2>
				@foreach ($rentals as $rental)
				@if ($rental->payments->payment_status == 'Cancel')
				<div class="card margin-top-10">
					<div class="margin-content">
						<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
							<p>Date : {{ date('jS F, Y', strtotime($rental->created_at)) }}</p>
							<p>Rented by : {{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
						</a>
					</div>
				</div>
				@endif
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection