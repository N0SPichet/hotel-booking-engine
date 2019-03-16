@extends ('admin.layouts.app')
@section ('title', 'Rentals')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="card col">
			<div class="card-title"><h1 class="title-page">Upcoming rentals</h1></div>
			<div class="card-body">
				<div class="row" align="center">
					<div class="margin-auto">
						{!! $rentals->links() !!}
					</div>
				</div>
				@foreach($rentals as $rental)
				<div class="card m-t-10">
					<div class="margin-content">
						<div class="col-md-6 float-left">
							<a href="{{ route('admin.rentals.show', $rental->id) }}" style="text-decoration-line: none;">
							<p><i class="fas fa-user"></i> Rented by : <span class="text-primary">{{ $rental->user->user_fname }}</span></p>
							<p><i class="far fa-calendar-alt"></i> Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }}</p>
							</a>
						</div>
						<div class="col-md-3 float-left" align="center">
							@if ($rental->host_decision == 'accept')
							@if ($rental->payment->payment_status == null)
								<button class="btn btn-secondary btn-sm m-b-10" style="width: 150px;">
								<div class="text-white">
									<div class="text-center">{{$rental->host_decision}} by host</div>
								</div>
								</button>
							@elseif ($rental->payment->payment_status == 'Waiting')
							{!! Form::open(['route' => ['admin.rentals.approve', $rental->id], 'method' => 'POST']) !!}
								<button type="submit" class="btn btn-primary btn-sm m-b-10" style="width: 150px;">
								<div class="text-white">
									<div class="text-center">{{ $rental->payment->payment_status }} for admin</div>
								</div>
								</button>
							{!! Form::close() !!}
							@elseif ($rental->payment->payment_status == 'Cancel')
								<button class="btn btn-secondary btn-sm m-b-10" style="width: 150px;">
								<div class="text-white">
									<div class="text-center">{{ $rental->payment->payment_status }} by renter</div>
								</div>
								</button>
							@elseif ($rental->payment->payment_status == 'Reject')
								<button class="btn btn-danger btn-sm m-b-10" style="width: 150px;">
								<div class="text-white">
									<div class="text-center">{{ $rental->payment->payment_status }} by admin</div>
								</div>
								</button>
							@elseif ($rental->payment->payment_status == 'Approved')
								<button class="btn btn-success btn-sm m-b-10">
								<div class="text-white">
									<div class="text-center">{{ $rental->payment->payment_status }} by admin</div>
								</div>
								</button>
							@elseif ($rental->payment->payment_status == 'Out of Date')
								<button class="btn btn-secondary btn-sm disabled" style="width: 150px;">
								<div class="text-white">
									<div class="text-center">{{ $rental->payment->payment_status }}</div>
								</div>
								</button>
							@endif
							@elseif ($rental->host_decision == 'waiting')
							@if ($rental->payment->payment_status == null)
								<button class="btn btn-secondary btn-sm m-b-10" style="width: 150px;">
								<div class="text-white">
									<div class="text-center">{{$rental->host_decision}} for host</div>
								</div>
								</button>
							@elseif ($rental->payment->payment_status == 'Cancel')
								<button class="btn btn-secondary btn-sm m-b-10" style="width: 150px;">
								<div class="text-white">
									<div class="text-center">{{ $rental->payment->payment_status }} by renter</div>
								</div>
								</button>
							@elseif ($rental->payment->payment_status == 'Reject')
								<button class="btn btn-danger btn-sm m-b-10" style="width: 150px;">
								<div class="text-white">
									<div class="text-center">{{ $rental->payment->payment_status }} by admin</div>
								</div>
								</button>
							@endif
							@else
								<button class="btn btn-danger btn-sm m-b-10" style="width: 150px;">
								<div class="text-white">
									<div class="text-center">{{ $rental->host_decision }} by host</div>
								</div>
								</button>
							@endif
						</div>
						<div class="col-md-3 float-left" align="center">
							{!! Html::linkRoute('admin.rentals.show', 'View Detail', array($rental->id), array('class' => 'btn btn-info btn-sm', 'style' => 'width: 150px')) !!}
							@if ($rental->payment->payment_status != 'Reject')
							{!! Form::open(['route' => ['admin.rentals.reject', $rental->id], 'method' => 'POST']) !!}
							{!! Form::submit('Reject this rental', ['class' => 'btn btn-danger btn-sm m-t-20', 'style' => 'width: 150px']) !!}
							{!! Form::close() !!}
							@endif
						</div>
					</div>
				</div>
				@endforeach
				<div class="row" align="center">
					<div class="margin-auto">
						{!! $rentals->links() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
