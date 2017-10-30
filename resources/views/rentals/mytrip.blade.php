@extends ('main')

@section ('title', 'My Trip')

@section ('content')

<div class="container">
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<div class="panel-heading text-center"> <h1>My Trips</h1> </div>
		</div>
	</div> <!-- end of header row-->

	<div class="row">
		<div class="col-md-12 col-md-offset-0">
				@foreach($rentals as $rental)
					<div class="row">
						<div class="col-md-5 col-sm-5">
							<p><b>House Name :  {{ $rental->houses->house_title }}  </b></p>
							<p>{{ date('jS F, Y', strtotime($rental->rental_datein)) }} <span class="glyphicon glyphicon-arrow-right"></span> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} </p>
							<p>{{ $rental->rental_guest }} guest</p>

							@if ( $rental->checkin_status == '1' )
								<p>Check in Status: <button class="btn-success">Granted</button></p>
							@elseif ($rental->checkin_status == '0')
								<p>Check in Status: <button class="btn-danger">Not check in</button></p>
							@endif
							
							<p>Created at {{ date('jS F, Y', strtotime($rental->created_at)) }} </p>
						</div>
						
						<div class="col-md-3 col-sm-3">
							<div class="text-center">
								<img src="{{ asset('images/payments/' . $rental->payments->payment_transfer_slip) }}" class="img-thumbnail" width="60" height="auto">
							</div>
						</div>

						@if($rental->payments->payment_status == 'Waiting')
						<div class="col-md-2 col-md-offset-0 col-sm-1 col-sm-offset-0 col-xs-10 col-xs-offset-1">
							<button type="submit" class="btn-h1-spacing btn btn-default btn-primary btn-block btn-sm disabled">
								<div class="text-white">
									<div class="text-center">{{ $rental->payments->payment_status }}</div>
								</div>
							</button>
						</div>
						@elseif($rental->payments->payment_status == 'Cancel')
						<div class="col-md-2 col-md-offset-0 col-sm-1 col-sm-offset-0 col-xs-10 col-xs-offset-1">
							<button type="submit" class="btn-h1-spacing btn btn-default btn-warning btn-block btn-sm disabled">
								<div class="text-white">
									<div class="text-center">{{ $rental->payments->payment_status }}</div>
								</div>
							</button>
						</div>
						@elseif($rental->payments->payment_status == 'Reject')
						<div class="col-md-2 col-md-offset-0 col-sm-1 col-sm-offset-0 col-xs-10 col-xs-offset-1">
							<button type="button" class="btn-h1-spacing btn btn-default btn-danger btn-block btn-sm disabled">
								<div class="text-white">
									<div class="text-center">{{ $rental->payments->payment_status }}</div>
								</div>
							</button>
						</div>
						@elseif($rental->payments->payment_status == 'Approved')
						<div class="col-md-2 col-md-offset-0 col-sm-1 col-sm-offset-0 col-xs-10 col-xs-offset-1">
							<button type="submit" class="btn-h1-spacing btn btn-default btn-success btn-block btn-sm disabled">
								<div class="text-white">
									<div class="text-center">{{ $rental->payments->payment_status }}</div>
								</div>
							</button>
						</div>
						@endif
						
						<div class="col-md-2 col-sm-2 col-xs-12">
							{!! Html::linkRoute('rentals.show', 'View Detail', array($rental->id), array('class' => 'btn btn-info btn-sm btn-block btn-h1-spacing')) !!}

							{!! Form::open(['route' => ['rental.rentalcancel', $rental->id], 'method' => 'POST']) !!}

							{{ csrf_field() }}

							{!! Form::submit('Cancel This Trip', ['class' => 'btn btn-danger btn-sm btn-block btn-h1-spacing']) !!}

							{!! Form::close() !!}
						</div>
					</div>
					<hr>			
				@endforeach
			</div>

			<div class="text-center">
				<!-- generate link for siary item -->
				{!! $rentals->links() !!}
			</div>

		</div>
	</div>
</div>

@endsection