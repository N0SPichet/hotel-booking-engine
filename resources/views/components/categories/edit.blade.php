@extends ('main')

@section ('title', 'Edit Category')

@section ('content')

<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('comp.categories.show', $category->id) }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Category</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-6">
			{!! Form::model($category, ['route' => ['comp.categories.update', $category->id], 'method' => 'PUT']) !!}
			{{ Form::label('name', 'Category name') }}
			{{ Form::text('name', null, ['class' => 'form-control']) }}
			{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-h1-spacing']) }}
			{!! Form::close() !!}
		</div>
	</div>
</div>

@endsection