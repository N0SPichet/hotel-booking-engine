@extends ('main')

@section ('title', "Administrator | $houseamenity->amenityname Amenity")

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<h1>{{ $houseamenity->amenityname }} Amenity <small>{{ $houseamenity->houses()->count() }} Rooms</small></h1>
		</div>
		<div class="col-md-2">
			<a href="{{ route('houseamenities.edit', $houseamenity->id) }}" class="btn btn-primary pull-right btn-block" style="margin-top: 20px;">Edit</a>
		</div>
		<div class="col-md-2">
			{!! Form::open(['route' => ['houseamenities.destroy', $houseamenity->id], 'method' => 'DELETE']) !!}

				{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'style' => 'margin-top: 20px;']) }}

			{!! Form::close() !!}
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Room</th>
						<th>Amenities</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					@foreach ($houseamenity->houses as $house)
					<tr>
						<th>{{ $house->id }}</th>
						<td>{{ $house->house_title }}</td>
						<td>
							@foreach ($house->houseamenities as $amenity)
								<span class="label label-default">{{ $amenity->amenityname }}</span>
							@endforeach
						</td>
						<td><a href="{{ route('rooms.show', $house->id) }}" class="btn btn-default btn-xs">View</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection