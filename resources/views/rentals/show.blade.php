@extends ('main')

@section ('title', 'Trip')

@section ('content')
<div class="container">
	<div class="row">
			<div class="col-md-8">
				<p class="lead">Rental #ID {{ $rental->id }} </p>
				<div class="col-md-12">
					<label>Booking Detail</label>
					<p>House Name :  {{ $rental->houses->house_title }}  </p>
					<p>Hosted by : {{ $rental->houses->users->user_fname }} {{ $rental->houses->users->user_lname }}</p>
					<p>Rented by : {{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
					<p>Address : {{ $rental->houses->house_address }} {{ $rental->houses->addresscities->city_name }} {{ $rental->houses->addressstates->state_name }}, {{ $rental->houses->addresscountries->country_name }}</p>
					<p> {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <span class="glyphicon glyphicon-arrow-right"></span> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} </p>
					<p> {{ $rental->rental_guest }} guest</p>
					<br>

					@if ( Auth::user()->id == $rental->users->id && $rental->payments->payment_status != 'Reject' )
					<p>Code : {{ $rental->checkincode }}</p>
					@endif
					
					@if ( $rental->checkin_status == '1' )
						<p>Check in Status: <button class="btn-success">Granted</button></p>
					@elseif ($rental->checkin_status == '0')
						<p>Check in Status: <button class="btn-danger">Denial</button></p>
					@endif

					<br>
				</div>
				
				<div class="col-md-6">
					<label>Payment</label>
					<p> Bank Name : {{ $rental->payments->payment_bankname }} </p>
					<p> Bank Holder : {{ $rental->payments->payment_holder }} </p>
					<p> Bank Account : {{ $rental->payments->payment_bankaccount }} </p>
					<p> Status : <b>{{ $rental->payments->payment_status }}</b> </p>
				</div>

				<div class="col-md-6">
					<div class="text-center">
						<img src="{{ asset('images/payments/' . $rental->payments->payment_transfer_slip) }}" class="img-thumbnail" width="60" height="auto">
					</div>
					<br>
					<p class="text-center">Transfer Slip</p>
				</div>
						
			</div>

			<div class="col-md-4">
				<div class="well">
					<div class="dl-horizontal">
						<label>Created by:</label>
						<p> {{ $rental->users->user_fname }} {{ $rental->users->user_lname }} </p>
						<label>Created at:</label>
						<p> {{ date('M j, Y', strtotime($rental->created_at)) }} </p>
						<label>Last update:</label>
						<p> {{ date('M j, Y', strtotime($rental->updated_at)) }} </p>
					</div>

					<hr>
					<div class="row">
						<div class="col-sm-6">
							<a href="{{ URL::previous() }}" class="btn btn btn-link btn-md">Back</a>
						</div>
					</div>
				</div>
			</div>
	</div> <!-- end of col-md-12 row-->
</div>
@endsection