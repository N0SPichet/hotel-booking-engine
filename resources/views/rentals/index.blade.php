@extends ('manages.main')
@section ('title', 'Administrator | Trips')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="card col">
			<div class="card-title"><h1 class="title-page">Rentals</h1></div>

			<div class="card-body">
				@foreach($rentals as $rental)
				<div class="card m-t-10">
					<div class="margin-content">
						<div class="col-md-7 float-left">
							<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;">
							<p><i class="fas fa-user"></i> Rented by : <span class="text-primary">{{ $rental->user->user_fname }}</span></p>
							<p><i class="far fa-calendar-alt"></i> Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }}</p>
							</a>
						</div>
						<div class="col-md-2 float-left" align="center">
							<p></p>
							@if($rental->payment->payment_status == 'Waiting')
							{!! Form::open(['route' => ['rentals.approve', $rental->id], 'method' => 'POST']) !!}
								<button type="submit" class="btn btn-primary btn-sm" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="far fa-check-circle"></i> {{ $rental->payment->payment_status }}</div>
								</div>
								</button>
							{!! Form::close() !!}
							@endif
								
							@if($rental->payment->payment_status == 'Cancel')
								<button class="btn btn-warning btn-sm disabled" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="fas fa-check"></i> {{ $rental->payment->payment_status }}</div>
								</div>
								</button>
							@elseif($rental->payment->payment_status == 'Reject')
								<button class="btn btn-danger btn-sm disabled" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="fas fa-check"></i> {{ $rental->payment->payment_status }}</div>
								</div>
								</button>
							@elseif($rental->payment->payment_status == 'Approved')
								<button class="btn btn-success btn-sm disabled" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="fas fa-check"></i> {{ $rental->payment->payment_status }}</div>
								</div>
								</button>
							@elseif($rental->payment->payment_status == 'Out of Date')
								<button class="btn btn-secondary btn-sm disabled" style="width: 80%;">
								<div class="text-white">
									<div class="text-center"><i class="fas fa-check"></i> {{ $rental->payment->payment_status }}</div>
								</div>
								</button>
							@endif
						</div>
						<div class="col-md-3 float-left" align="center">
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