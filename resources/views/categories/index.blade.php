@extends ('main')

@section ('title', 'Administrator | Catagories')

@section ('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<h1>Categories</h1>
				<table class="table">

					<thead>
						<tr>
							<th>#</th>
							<th>name</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($categories as $category)
						<tr>
							<td> {{ $category->id }} </td>
							<td> {{ $category->category_name }} </td>
						</tr>
						@endforeach
					</tbody>

				</table>
			</div>

			<div class="col-md-3">
				<div class="well">
					{!! Form::open(['route' => 'categories.store', 'method' => 'POST']) !!}
						{{ csrf_field() }}
						
						<h2>New Category</h2>
						{{ Form::label('category_name', 'Name:') }}
						{{ Form::text('category_name', null, ['class' => 'form-control input-lg']) }}

						{{ Form::submit('Create New Category', ['class' => 'btn btn-primary btn-block']) }}
					{!! Form::close() !!}
				</div>
				
			</div>
		</div>
	</div>

@endsection