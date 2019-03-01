@extends ('manages.main')
@section ('title', 'Rentals | History')
@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-12">
			<a href="{{ route('rentals.rentmyrooms', Auth::user()->id) }}" class="btn btn-outline-secondary"> Back to Rentals</a>
		</div>
		<div class="col-md-4 float-left">
			<div class="card m-t-10">
				<h2 class="text-success margin-content">Approved</h2>
				@foreach ($rentals_approved as $rental)
				<div class="card m-t-10">
					<div class="margin-content">
						<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
							<p>Date : {{ date('jS F, Y', strtotime($rental->created_at)) }}</p>
							<p>Rented by : {{ $rental->user->user_fname }} {{ $rental->user->user_lname }}</p>
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

		<div class="col-md-4 float-left">
			<div class="card m-t-10">
				<h2 class="text-danger margin-content">Rejected</h2>
				@foreach ($rentals as $rental)
				@if ($rental->payment->payment_status == 'Reject' || $rental->host_decision == 'REJECT')
				<div class="card m-t-10">
					<div class="margin-content">
						<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
							<p>Date : {{ date('jS F, Y', strtotime($rental->created_at)) }}</p>
							<p>Rented by : {{ $rental->user->user_fname }} {{ $rental->user->user_lname }}</p>
						</a>
					</div>
				</div>
				@endif
				@endforeach
			</div>
		</div>

		<div class="col-md-4 float-left">
			<div class="card m-t-10">
				<h2 class="text-warning margin-content">Cancel</h2>
				@foreach ($rentals as $rental)
				@if ($rental->payment->payment_status == 'Cancel')
				<div class="card m-t-10">
					<div class="margin-content">
						<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
							<p>Date : {{ date('jS F, Y', strtotime($rental->created_at)) }}</p>
							<p>Rented by : {{ $rental->user->user_fname }} {{ $rental->user->user_lname }}</p>
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
