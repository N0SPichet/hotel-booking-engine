@extends ('main')

@section ('title', 'Administrator | Amenities')

@section ('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<h1>Amenities</h1>
				<table class="table">

					<thead>
						<tr>
							<th>#</th>
							<th>Detail</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($houseamenities as $houseamenity)
						<tr>
							<td> {{ $houseamenity->id }} </td>
							<td><a href="{{ route('houseamenities.show', $houseamenity->id) }}"> {{ $houseamenity->amenityname }} </a></td>
						</tr>
						@endforeach
					</tbody>

				</table>
			</div>

			<div class="col-md-3">
				<div class="well">
					{!! Form::open(['route' => 'houseamenities.store', 'method' => 'POST']) !!}
						
						<h2>New House Amenity</h2>
						{{ Form::label('amenityname', 'Name:') }}
						{{ Form::text('amenityname', null, ['class' => 'form-control input-lg']) }}

						{{ Form::submit('Create New Amenity', ['class' => 'btn btn-primary btn-block']) }}
					{!! Form::close() !!}
				</div>
				
			</div>
		</div>
	</div>

@endsection