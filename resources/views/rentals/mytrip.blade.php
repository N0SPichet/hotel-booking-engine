@extends ('dashboard.main')
@section ('title', 'Your Trips')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('dashboard.trips.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="panel-heading text-center "><h1 class="title-page">Your Trips</h1></div>
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
					<div class="col-md-6 float-left">
						<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
						@if ($rental->payment->payment_status == 'Approved' && $rental->checkin_status == '0' )
						<p class="text-primary"><b>payment complete.</b></p>
						@elseif ( $rental->payment->payment_status == 'Approved' && $rental->checkin_status == '1' )
						<p class="text-success"><b>checkin confirmed.</b></p>
						@elseif ( $rental->host_decision == 'accept' && $rental->checkin_status == '0' )
						<p class="text-primary"><b>host accepted.</b></p>
						@else
						<p class="text-danger">{{$rental->payment->payment_status!=null?"payment ".$rental->payment->payment_status:$rental->host_decision." host"}}</p>
						@endif
						<p>@if ($rental->house->checkType($rental->house_id)) <img src="{{ asset('images/houses/house.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> @else <img src="{{ asset('images/houses/apartment.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> @endif Room Name :  {{ $rental->house->house_title }}  </p>
						<p><i class="far fa-calendar-alt"></i> Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} ({{ Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout)) }} {{ Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout))>'1'?'days':'day' }}) </p>
						<p><i class="far fa-user"></i> {{ $rental->rental_guest }} guest</p>
						</a>
					</div>
								
					<div class="col-md-2 float-left" align="center">
						<p></p>
						@if ($rental->payment->payment_transfer_slip != NULL)
						<img src="{{ asset('images/payments/'.$rental->payment_id.'/'.$rental->payment->payment_transfer_slip) }}" class="img-thumbnail" width="60" height="auto">
						@endif
					</div>

					<div class="col-md-2 float-left" align="center">
						<p></p>
						@if ($rental->host_decision == 'accept')
						@if ($rental->payment->payment_status == null)
							<button class="btn btn-primary btn-sm" style="width: 150px;">
							<div class="text-white">
								<div class="text-center">{{$rental->host_decision}} by host</div>
							</div>
							</button>
						@elseif ($rental->payment->payment_status == 'Waiting')
							<button class="btn btn-secondary btn-sm" style="width: 150px;">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }} for admin</div>
							</div>
							</button>
						@elseif ($rental->payment->payment_status == 'Cancel')
							<button class="btn btn-secondary btn-sm" style="width: 150px;">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }} by renter</div>
							</div>
							</button>
						@elseif ($rental->payment->payment_status == 'Reject')
							<button class="btn btn-danger btn-sm" style="width: 150px;">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }} by admin</div>
							</div>
							</button>
						@elseif ($rental->payment->payment_status == 'Approved')
							<button class="btn btn-success btn-sm" style="width: 150px;">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }} by admin</div>
							</div>
							</button>
						@endif
						@elseif ($rental->host_decision == 'waiting')
						@if ($rental->payment->payment_status == null)
							<button class="btn btn-secondary btn-sm" style="width: 150px;">
							<div class="text-white">
								<div class="text-center">{{$rental->host_decision}} for host</div>
							</div>
							</button>
						@elseif ($rental->payment->payment_status == 'Cancel')
							<button class="btn btn-secondary btn-sm" style="width: 150px;">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }} by renter</div>
							</div>
							</button>
						@elseif ($rental->payment->payment_status == 'Reject')
							<button class="btn btn-danger btn-sm" style="width: 150px;">
							<div class="text-white">
								<div class="text-center">{{ $rental->payment->payment_status }} by admin</div>
							</div>
							</button>
						@endif
						@else
							<button class="btn btn-danger btn-sm" style="width: 150px;">
							<div class="text-white">
								<div class="text-center">{{ $rental->host_decision }} by host</div>
							</div>
							</button>
						@endif
					</div>
							
					<div class="col-md-2 float-left" align="center">
						@if ($rental->host_decision == 'accept')
							@if ($rental->payment->payment_status == NULL)
							{!! Html::linkRoute('rentals.edit', 'Payment', array($rental->id), array('class' => 'btn btn-success btn-sm m-t-10', 'style' => "width: 150px;")) !!}
							@else
							<button type="button" class="btn btn-success btn-sm m-t-10" style="width: 150px;">Payment Submitted</button>
							@endif
						@endif
						{!! Html::linkRoute('rentals.show', 'View Detail', array($rental->id), array('class' => 'btn btn-info btn-sm m-t-10', 'style' => "width: 150px;")) !!}
						{!! Form::open(['route' => ['rentals.cancel', $rental->id], 'method' => 'POST']) !!}
						{!! Form::submit('Cancel This Trip', ['class' => 'btn btn-danger btn-sm m-t-10', 'style' =>"width: 150px;"]) !!}
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
