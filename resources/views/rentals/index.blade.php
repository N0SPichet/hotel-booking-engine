@extends ('main')

@section ('title', 'Administrator | Trips')

@section ('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default col">
			<div class="panel-heading"><h1 class="title-page">Rentals</h1></div>

			<div class="panel-body">
				@foreach($rentals as $rental)
				<div class="card margin-top-10">
					<div class="margin-content">
						<div class="col-md-7">
							<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
							<p><i class="fas fa-user"></i> Rented by : <span class="text-primary">{{ $rental->users->user_fname }}</span></p>
							<p><i class="far fa-calendar-alt"></i> Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }}</p>
							</a>
						</div>
						<div class="col-md-2" align="center">
							@if($rental->payments->payment_status == 'Waiting')
							{!! Form::open(['route' => ['rentals.approve', $rental->id], 'method' => 'POST']) !!}
								<button type="submit" class="btn btn-primary btn-sm" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="far fa-check-circle"></i> {{ $rental->payments->payment_status }}</div>
								</div>
								</button>
							{!! Form::close() !!}
							@endif
								
							@if($rental->payments->payment_status == 'Cancel')
								<button class="btn btn-warning btn-sm disabled" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="fas fa-check"></i> {{ $rental->payments->payment_status }}</div>
								</div>
								</button>
							@elseif($rental->payments->payment_status == 'Reject')
								<button class="btn btn-danger btn-sm disabled" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="fas fa-check"></i> {{ $rental->payments->payment_status }}</div>
								</div>
								</button>
							@elseif($rental->payments->payment_status == 'Approved')
								<button class="btn btn-success btn-sm disabled" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="fas fa-check"></i> {{ $rental->payments->payment_status }}</div>
								</div>
								</button>
							@elseif($rental->payments->payment_status == 'Out of Date')
								<button class="btn btn-secondary btn-sm disabled" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="fas fa-check"></i> {{ $rental->payments->payment_status }}</div>
								</div>
								</button>
							@endif
						</div>
						<div class="col-md-3" align="center">
							{!! Html::linkRoute('rentals.show', 'View Detail', array($rental->id), array('class' => 'btn btn-info btn-sm', 'style' => 'width: 60%')) !!}
							{!! Form::open(['route' => ['rentals.reject', $rental->id], 'method' => 'POST']) !!}
							{!! Form::submit('Reject this rental', ['class' => 'btn btn-danger btn-sm btn-h1-spacing', 'style' => 'width: 60%']) !!}
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				@endforeach
			</div>
		<div class="text-center">
			{!! $rentals->links() !!}
		</div>
	</div>
</div>

@endsection