@extends ('main')

@section ('title', 'Administrator | House rules')

@section ('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<h1>House Rules</h1>
				<table class="table">

					<thead>
						<tr>
							<th>#</th>
							<th>Detail</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($houserules as $houserule)
						<tr>
							<td> {{ $houserule->id }} </td>
							<td> {{ $houserule->houserule_name }} </td>
						</tr>
						@endforeach
					</tbody>

				</table>
			</div>

			<div class="col-md-3">
				<div class="well">
					{!! Form::open(['route' => 'houserules.store', 'method' => 'POST']) !!}
						{{ csrf_field() }}
						
						<h2>New House Rule</h2>
						{{ Form::label('houserule_name', 'Name:') }}
						{{ Form::text('houserule_name', null, ['class' => 'form-control input-lg']) }}

						{{ Form::submit('Create New Rule', ['class' => 'btn btn-primary btn-block']) }}
					{!! Form::close() !!}
				</div>
				
			</div>
		</div>
	</div>

@endsection