@extends ('manages.main')
@section ('title', 'Edit Rule')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('comp.rules.show', $rule->id) }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Rule</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-6">
			{!! Form::model($rule, ['route' => ['comp.rules.update', $rule->id], 'method' => 'PUT']) !!}
			{{ Form::label('name', 'Rule name') }}
			{{ Form::text('name', null, ['class' => 'form-control']) }}
			{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-h1-spacing']) }}
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection