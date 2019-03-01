@extends ('main')

@section ('title', "Administrator | $category->name Category")

@section('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('comp.categories.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Categories</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-8">
			<h1>{{ $category->name }} <small>(has {{ $category->diaries()->count() }} Diaries)</small></h1>
		</div>
		<div class="col-md-2">
			<a href="{{ route('comp.categories.edit', $category->id) }}" class="btn btn-primary pull-right btn-block m-t-10">Edit</a>
		</div>
		<div class="col-md-2">
			{!! Form::open(['route' => ['comp.categories.destroy', $category->id], 'method' => 'DELETE']) !!}
				{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-block m-t-10']) }}
			{!! Form::close() !!}
		</div>
	</div>

	<div class="row m-t-10">
		<div class="col-md-12">
			@if($category->diaries()->count())
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Room</th>
						<th>Categories</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($category->diaries as $diary)
					<tr>
						<th>{{ $diary->id }}</th>
						<td>{{ $diary->title }}</td>
						<td>{{ $category->name }}</td>
						<td>
							<a target="_blank" href="{{ route('diaries.show', $diary->id) }}" class="btn btn-outline-primary btn-sm m-t-10">View as Public</a>
							<a target="_blank" href="{{ route('diaries.single', $diary->id) }}" class="btn btn-outline-danger btn-sm m-t-10">View as Owner</a>
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