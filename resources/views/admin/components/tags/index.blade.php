@extends ('admin.layouts.app')
@section ('title', 'Administrator | Tags')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-8">
			<h1>Tags</h1>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Tag</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($tags as $tag)
					<tr>
						<td> {{ $tag->id }} </td>
						<td><a href="{{ route('comp.tags.show', $tag->id) }}"> {{ $tag->name }} <span class="{{ $tag->diaries()->count()>0? 'text-success':'text-danger' }}">({{ $tag->diaries()->count() }} diaries use this tag)</span></a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-3">
			<div class="well">
				{!! Form::open(['route' => 'comp.tags.store', 'method' => 'POST']) !!}
					
					<h2>New Tag</h2>
					{{ Form::label('name', 'Name:') }}
					{{ Form::text('name', null, ['class' => 'form-control input-lg']) }}

					{{ Form::submit('Create New Tag', ['class' => 'btn btn-primary btn-block m-t-10']) }}
				{!! Form::close() !!}
			</div>
			
		</div>
	</div>
</div>
@endsection
