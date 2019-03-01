@extends ('main')
@section ('title', 'Administrator | Rules')
@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-8">
			<h1>Rules</h1>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Rule</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($rules as $rule)
					<tr>
						<td> {{ $rule->id }} </td>
						<td><a href="{{ route('comp.rules.show', $rule->id) }}"> {{ $rule->name }} <span class="{{ $rule->houses()->count()>0? 'text-success':'text-danger' }}">({{ $rule->houses()->count() }} rooms use this rule)</span></a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-3">
			<div class="well">
				{!! Form::open(['route' => 'comp.rules.store', 'method' => 'POST']) !!}
					
					<h2>New House Rule</h2>
					{{ Form::label('name', 'Name:') }}
					{{ Form::text('name', null, ['class' => 'form-control input-lg']) }}

					{{ Form::submit('Create New Rule', ['class' => 'btn btn-primary btn-block m-t-10']) }}
				{!! Form::close() !!}
			</div>
			
		</div>
	</div>
</div>
@endsection
