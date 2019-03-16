@extends ('admin.layouts.app')
@section ('title', 'Edit Tag')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('comp.tags.show', $tag->id) }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Tag</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-6">
			{!! Form::model($tag, ['route' => ['comp.tags.update', $tag->id], 'method' => 'PUT']) !!}
			{{ Form::label('name', 'Tag name') }}
			{{ Form::text('name', null, ['class' => 'form-control']) }}
			{{ Form::submit('Save Changes', ['class' => 'btn btn-success m-t-20']) }}
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
