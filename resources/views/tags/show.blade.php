@extends ('main')

@section ('title', "Administrator | $tag->tag_name Tag")

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<h1>{{ $tag->tag_name }} Tag <small>{{ $tag->diaries()->count() }} Diaries</small></h1>
		</div>
		<div class="col-md-2">
			<a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-primary pull-right btn-block" style="margin-top: 20px;">Edit</a>
		</div>
		<div class="col-md-2">
			{!! Form::open(['route' => ['tags.destroy', $tag->id], 'method' => 'DELETE']) !!}

				{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'style' => 'margin-top: 20px;']) }}

			{!! Form::close() !!}
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
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
							@foreach ($diary->tags as $tag)
								<span class="label label-default">{{ $tag->tag_name }}</span>
							@endforeach
						</td>
						<td><a href="{{ route('diaries.show', $diary->id) }}" class="btn btn-default btn-xs">View</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection