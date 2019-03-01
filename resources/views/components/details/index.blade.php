@extends ('main')
@section ('title', 'Administrator | Details')
@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-8">
			<h1>Details</h1>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Detail</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($details as $detail)
					<tr>
						<td> {{ $detail->id }} </td>
						<td><a href="{{ route('comp.details.show', $detail->id) }}"> {{ $detail->name }} <span class="{{ $detail->houses()->count()>0? 'text-success':'text-danger' }}">({{ $detail->houses()->count() }} rooms use this detail)</span></a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-3">
			<div class="well">
				{!! Form::open(['route' => 'comp.details.store', 'method' => 'POST']) !!}
					
					<h2>New House Detail</h2>
					{{ Form::label('name', 'Name:') }}
					{{ Form::text('name', null, ['class' => 'form-control input-lg']) }}

					{{ Form::submit('Create New Detail', ['class' => 'btn btn-primary btn-block m-t-10']) }}
				{!! Form::close() !!}
			</div>
			
		</div>
	</div>
</div>
@endsection
