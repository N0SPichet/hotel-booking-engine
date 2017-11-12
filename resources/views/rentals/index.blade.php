@extends ('main')

@section ('title', 'Administrator | Trips')

@section ('content')

<div class="container">
	<div class="row">
		<div class="col-md-10">
			<h1>Trips</h1>
		</div>
	</div> <!-- end of header row-->

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<th class="text-center">#ID</th>
					<th class="text-center">Rented by</th>
					<th class="text-center">Stay Date</th>
					<th class="text-center">Status</th>
					<th class="text-center">Payment #ID</th>
					<th></th>
				</thead>

				<tbody>

					@foreach($rentals as $rental)
						<tr>
							<th class="text-center" width="10px"> {{ $rental->id }} </th>
							<td class="text-center"> {{ $rental->users->user_fname }} </td>
							<td class="text-center"> {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <span class="glyphicon glyphicon-arrow-right"></span> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} </td>
							<td>
								{!! Form::open(['route' => ['rentals.approve', $rental->id], 'method' => 'POST']) !!}
									@if($rental->payments->payment_status == 'Waiting')
									<button type="submit" class="btn btn-default btn-primary btn-block btn-sm">
									<div class="text-white">
										<div class="text-center">{{ $rental->payments->payment_status }}</div>
									</div>
									</button>
									@endif
								{!! Form::close() !!}
								
								@if($rental->payments->payment_status == 'Cancel')
									<button type="button" class="btn btn-default btn-warning btn-block btn-sm disabled">
									<div class="text-white">
										<div class="text-center">{{ $rental->payments->payment_status }}</div>
									</div>
									</button>
								@elseif($rental->payments->payment_status == 'Reject')
									<button type="button" class="btn btn-default btn-danger btn-block btn-sm disabled">
									<div class="text-white">
										<div class="text-center">{{ $rental->payments->payment_status }}</div>
									</div>
									</button>
								@elseif($rental->payments->payment_status == 'Approved')
									<button type="button" class="btn btn-default btn-success btn-block btn-sm disabled">
									<div class="text-white">
										<div class="text-center">{{ $rental->payments->payment_status }}</div>
									</div>
									</button>
								@endif
							</td>
							<td class="text-center"> {{ $rental->payments->id }} </td>
							<td class="text-center">
								{!! Html::linkRoute('rentals.show', 'View Detail', array($rental->id), array('class' => 'btn btn-info btn-sm btn-block')) !!}

								{!! Form::open(['route' => ['rentals.reject', $rental->id], 'method' => 'POST']) !!}

								{!! Form::submit('Reject this rental', ['class' => 'btn btn-danger btn-sm btn-block btn-h1-spacing']) !!}

								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach

				</tbody>
			</table>
			<div class="text-center">
				<!-- generate link for siary item -->
				{!! $rentals->links() !!}
			</div>
		</div>
	</div>
</div>

@endsection