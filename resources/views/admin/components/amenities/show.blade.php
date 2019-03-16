@extends ('admin.layouts.app')
@section ('title', "$amenity->name Amenity")

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('comp.amenities.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Amenities</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-8">
			<h1>{{ $amenity->name }} <small>(has {{ $amenity->houses()->count() }} Rooms)</small></h1>
		</div>
		<div class="col-md-2">
			<a href="{{ route('comp.amenities.edit', $amenity->id) }}" class="btn btn-primary pull-right btn-block m-t-10">Edit</a>
		</div>
		<div class="col-md-2">
			{!! Form::open(['route' => ['comp.amenities.destroy', $amenity->id], 'method' => 'DELETE']) !!}
				{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-block m-t-10']) }}
			{!! Form::close() !!}
		</div>
	</div>

	<div class="row m-t-10">
		<div class="col-md-12">
			@if($amenity->houses()->count())
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
					@foreach ($amenity->houses as $house)
					<tr>
						<th>{{ $house->id }}</th>
						<td>{{ $house->house_title }}</td>
						<td>
							@foreach ($house->houseamenities as $key => $amenity)
								<span><a href="{{ route('comp.amenities.show', $amenity->id) }}">{{ $amenity->name }}</a></span>
								@if($house->houseamenities->count() != $key+1)
								,
								@endif
							@endforeach
						</td>
						<td>
							<a target="_blank" href="{{ route('rooms.show', $house->id) }}" class="btn btn-outline-primary btn-sm m-t-10">View as Public</a>
							<a target="_blank" href="{{ route('rooms.owner', $house->id) }}" class="btn btn-outline-danger btn-sm m-t-10">View as Owner</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
		</div>
	</div>
</div>
@endsection
