@extends ('dashboard.main')
@section ('title', "Administrator | $tag->name Tag")

@section('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('comp.tags.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Tags</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-8">
			<h1>{{ $tag->name }} <small>(has {{ $tag->diaries()->count() }} Diaries)</small></h1>
		</div>
		<div class="col-md-2">
			<a href="{{ route('comp.tags.edit', $tag->id) }}" class="btn btn-primary pull-right btn-block m-t-10">Edit</a>
		</div>
		<div class="col-md-2">
			{!! Form::open(['route' => ['comp.tags.destroy', $tag->id], 'method' => 'DELETE']) !!}
				{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-block m-t-10']) }}
			{!! Form::close() !!}
		</div>
	</div>

	<div class="row m-t-10">
		<div class="col-md-12">
			@if($tag->diaries()->count())
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Room</th>
						<th>Tags</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					@foreach ($tag->diaries as $diary)
					<tr>
						<th>{{ $diary->id }}</th>
						<td>{{ $diary->title }}</td>
						<td>
							@foreach ($diary->tags as $key => $tag)
								<span><a href="{{ route('comp.tags.show', $tag->id) }}">{{ $tag->name }}</a></span>
								@if($diary->tags->count() != $key+1)
								,
								@endif
							@endforeach
						</td>
						<td>
							<a target="_blank" href="{{ route('rooms.show', $diary->id) }}" class="btn btn-outline-primary btn-sm m-t-10">View as Public</a>
							<a target="_blank" href="{{ route('rooms.owner', $diary->id) }}" class="btn btn-outline-danger btn-sm m-t-10">View as Owner</a>
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
