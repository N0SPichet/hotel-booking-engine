@extends ('manages.main')
@section ('title', 'Administrator | Categories')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-8">
			<h1>Categories</h1>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Detail</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($categories as $category)
					<tr>
						<td> {{ $category->id }} </td>
						<td><a href="{{ route('comp.categories.show', $category->id) }}"> {{ $category->name }} <span class="{{ $category->diaries()->count()>0? 'text-success':'text-danger' }}">({{ $category->diaries()->count() }} diaries use this category)</span></a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-3">
			<div class="well">
				{!! Form::open(['route' => 'comp.categories.store', 'method' => 'POST']) !!}
					
					<h2>New Category</h2>
					{{ Form::label('name', 'Name:') }}
					{{ Form::text('name', null, ['class' => 'form-control input-lg']) }}

					{{ Form::submit('Create New Category', ['class' => 'btn btn-primary btn-block m-t-10']) }}
				{!! Form::close() !!}
			</div>
			
		</div>
	</div>
</div>
@endsection
