@extends ('main')

@section ('title', 'Edit Tag')

@section ('content')

<div class="container">
	<div class="row">
		{!! Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' => 'PUT']) !!}

			{{ Form::label('tag_name', 'Title') }}
			{{ Form::text('tag_name', null, ['class' => 'form-control']) }}

			{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-h1-spacing']) }}

		{!! Form::close() !!}
	</div>
</div>

@endsection