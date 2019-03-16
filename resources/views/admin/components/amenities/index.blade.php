@extends ('admin.layouts.app')
@section ('title', 'Amenities')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-8">
			<h1>Amenities</h1>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Detail</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($amenities as $amenity)
					<tr>
						<td> {{ $amenity->id }} </td>
						<td><a href="{{ route('comp.amenities.show', $amenity->id) }}"> {{ $amenity->name }} <span class="{{ $amenity->houses()->count()>0? 'text-success':'text-danger' }}">({{ $amenity->houses()->count() }} rooms use this amenity)</span></a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-3">
			<div class="well">
				{!! Form::open(['route' => 'comp.amenities.store', 'method' => 'POST']) !!}
					
					<h2>New House Amenity</h2>
					{{ Form::label('name', 'Name:') }}
					{{ Form::text('name', null, ['class' => 'form-control input-lg']) }}

					{{ Form::submit('Create New Amenity', ['class' => 'btn btn-primary btn-block m-t-10']) }}
				{!! Form::close() !!}
			</div>
			
		</div>
	</div>
</div>
@endsection
