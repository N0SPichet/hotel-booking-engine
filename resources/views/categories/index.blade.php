@extends ('main')
@section ('title', 'Administrator | Catagories')
@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-8 float-left">
			<h1>Categories</h1>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>name</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($categories as $category)
					<tr class="edit">
						<td>{{ $category->id }}</td>
						<td class="name">{{ $category->name }}</td>
						<td class="url">
							{!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE']) !!}
								{!! Form::submit('Delete', ['class' => 'btn btn-warning btn-sm float-left']) !!}
							{!! Form::close() !!}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-3 float-left">
			<div class="well">
				{!! Form::open(['route' => 'categories.store', 'method' => 'POST']) !!}
					{{ csrf_field() }}
					<h2>New Category</h2>
					{{ Form::label('category', 'Name:') }}
					{{ Form::text('category', null, ['class' => 'form-control input-lg']) }}
					{{ Form::submit('Create New Category', ['class' => 'btn btn-primary btn-block m-t-10']) }}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		
	});
</script>
@endsection
