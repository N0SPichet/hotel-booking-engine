@extends ('main')

@section ('title', 'Your Trip')

@section ('content')

<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="panel-heading text-center "> <h1 class="title-page">Your Trips</h1> </div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<h4>
				<a class="btn btn-outline-dark btn-md" href="{{ route('rentals.mytrips', Auth::user()->id) }}">Show All</a>
				<a class="btn btn-outline-dark btn-md" href="{{ route('rentals.notreviews', Auth::user()->id) }}">Pending reviews <span class="badge badge-danger">{{ $review_count }}</span></a>
			</h4>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			@foreach($rentals as $rental)
			<div class="card m-t-10">
				<div class="margin-content">
					<div class="col-md-5 float-left">
						<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
						@if ($rental->payment->payment_status == 'Approved' && $rental->checkin_status == '0' )
						<p class="text-primary"><b>Payment Complete.</b></p>
						@elseif ( $rental->host_decision == 'ACCEPT' && $rental->checkin_status == '0' )
						<p class="text-primary"><b>Host Accepted.</b></p>
						@elseif ( $rental->payment->payment_status == 'Approved' && $rental->checkin_status == '1' )
						<p class="text-success"><b>Confirmed.</b></p>
						@endif
						<p>@if($rental->houses->checkType($rental->houses->id)) <img src="{{ asset('images/houses/house.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> @else <img src="{{ asset('images/houses/apartment.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> @endif Room Name :  {{ $rental->houses->house_title }}  </p>
						<p><i class="far fa-calendar-alt"></i> Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} </p>
						<p><i class="far fa-user"></i> {{ $rental->rental_guest }} guest</p>
						</a>
					</div>
								
					<div class="col-md-3 float-left" align="center">
						<p></p>
						@if ($rental->payment->payment_transfer_slip != NULL)
						<img src="{{ asset('images/payments/'.$rental->payment_id.'/'.$rental->payment->payment_transfer_slip) }}" class="img-thumbnail" width="60" height="auto">
						@endif
						@if ($rental->host_decision == NULL && $rental->payment->payment_status != 'Cancel')
						<p class="text-warning">Waiting</p> 
						<p>for <b class="text-primary">host accept</b> your request</p>
						@elseif ($rental->host_decision == 'REJECT' && $rental->payment->payment_status != 'Cancel')
						<p class="text-danger">Rejected</p> 
						<p>your request was rejected by host</p>
						@endif
					</div>

					<div class="col-md-2 float-left" align="center">
						<p></p>
						@if($rental->payment->payment_status == 'Waiting')
						<button class="btn-h1-spacing btn btn-primary btn-sm" style="width: 60%">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }}</div>
							</div>
						</button>
						@elseif($rental->payment->payment_status == 'Cancel')
						<button type="submit" class="btn-h1-spacing btn btn-warning btn-sm disabled" style="width: 60%">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }}</div>
							</div>
						</button>
						@elseif($rental->payment->payment_status == 'Reject')
						<button type="button" class="btn-h1-spacing btn-danger btn-sm disabled" style="width: 60%">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }}</div>
							</div>
						</button>
						@elseif($rental->payment->payment_status == 'Approved')
						<button class="btn-h1-spacing btn btn-success btn-sm" style="width: 60%">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }}</div>
							</div>
						</button>
						@endif
					</div>
							
					<div class="col-md-2 float-left" align="center">
						@if ($rental->host_decision == 'ACCEPT')
							@if ($rental->payment->payment_status == NULL)
							{!! Html::linkRoute('rentals.edit', 'Payment', array($rental->id), array('class' => 'btn btn-success btn-sm m-t-10', 'style' => "width: 90%")) !!}
							@else
							<button type="button" class="btn btn-success btn-sm m-t-10" style="width: 95%">Payment Submitted</button>
							@endif
						@endif
						{!! Html::linkRoute('rentals.show', 'View Detail', array($rental->id), array('class' => 'btn btn-info btn-sm m-t-10', 'style' => "width: 90%")) !!}
						{!! Form::open(['route' => ['rentals.cancel', $rental->id], 'method' => 'POST']) !!}
						{!! Form::submit('Cancel This Trip', ['class' => 'btn btn-danger btn-sm m-t-10', 'style' =>"width: 90%"]) !!}
						{!! Form::close() !!}
					</div>
				</div>	
			</div>
			@endforeach
			<div class="text-center">
				{!! $rentals->links() !!}
			</div>
		</div>
	</div>
</div>

@endsection