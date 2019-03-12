@extends ('dashboard.main')
@section ('title', 'Edit Detail')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('comp.details.show', $detail->id) }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Detail</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-6">
			{!! Form::model($detail, ['route' => ['comp.details.update', $detail->id], 'method' => 'PUT']) !!}
			{{ Form::label('name', 'Detail name') }}
			{{ Form::text('name', null, ['class' => 'form-control']) }}
			{{ Form::submit('Save Changes', ['class' => 'btn btn-success m-t-20']) }}
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
