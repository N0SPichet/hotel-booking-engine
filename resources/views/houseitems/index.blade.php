@extends ('main')

@section ('title', 'Administrator | House Items')

@section ('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<h1>House Items</h1>
				<table class="table">

					<thead>
						<tr>
							<th>#</th>
							<th>name</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($houseitems as $houseitem)
						<tr>
							<td> {{ $houseitem->id }} </td>
							<td> {{ $houseitem->houseitem_name }} </td>
						</tr>
						@endforeach
					</tbody>

				</table>
			</div>

			<div class="col-md-3">
				<div class="well">
					{!! Form::open(['route' => 'houseitems.store', 'method' => 'POST']) !!}
						{{ csrf_field() }}
						
						<h2>New House Item</h2>
						{{ Form::label('houseitem_name', 'Name:') }}
						{{ Form::text('houseitem_name', null, ['class' => 'form-control input-lg']) }}

						{{ Form::submit('Create New Item', ['class' => 'btn btn-primary btn-block']) }}
					{!! Form::close() !!}
				</div>
				
			</div>
		</div>
	</div>

@endsection