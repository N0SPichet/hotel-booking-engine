@extends ('main')

@section ('title', 'Edit Amenity')

@section ('content')

<div class="container">
	<div class="row">
		{!! Form::model($houseamenity, ['route' => ['houseamenities.update', $houseamenity->id], 'method' => 'PUT']) !!}

			{{ Form::label('amenityname', 'Amenity name') }}
			{{ Form::text('amenityname', null, ['class' => 'form-control']) }}

			{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-h1-spacing']) }}

		{!! Form::close() !!}
	</div>
</div>

@endsection