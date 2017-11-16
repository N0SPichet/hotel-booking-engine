@extends ('main')

@section ('title', $diary->users->user_fname. ' | ' .'My Diary')

@section ('content')
<div class="container">
	<div class="row">
			<div class="col-md-8">
				<h1>{{ $diary->title }}</h1>
				<p> {{ $diary->message }}</p>
				<hr>
				<div class="tags">
					@foreach ($diary->tags as $tag)
						<span class="label label-default">{{ $tag->tag_name }}</span>
					@endforeach
				</div>
				<hr>
				<p>Public by : {{ $diary->users->user_fname }}</p>
				<p>Publish date : {{ date('jS F, Y', strtotime($diary->created_at)) }}</p>

				<div class="backend-comment" style="margin-top: 50px;">
					<h3>Comments <small>{{ $diary->comments()->count() }} total</small></h3>

					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Comment</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($diary->comments as $comment)
							<tr>
								<td>{{ $comment->name }}</td>
								<td>{{ $comment->email }}</td>
								<td>{{ $comment->comment }}</td>
								<td>
									<a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this comment?');"><span class="glyphicon glyphicon-trash"></span></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-4">
				<div class="well">
					<div class="dl-horizontal">
						<label>Category:</label>
						<p> {{ $diary->categories->category_name }}</p>
					</div>
					@if ($diary->users_id == Auth::user()->id)
					<div class="row">
						<div class="col-sm-6">
							{!! Html::linkRoute('diaries.edit', 'Edit', array($diary->id), array('class' => 'btn btn-primary btn-block btn-h1-spacing')) !!}
						</div>
						<div class="col-sm-6">
							{!! Form::open(['route' => ['diaries.destroy', $diary->id], 'method' => 'DELETE']) !!}

							{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block btn-h1-spacing']) !!}

							{!! Form::close() !!}
						</div>
					</div>
					@endif
					<hr>
					<div class="row">
						<div class="col-sm-6">
							{!! Html::linkRoute('diaries.mydiaries', 'Back to My Diary', array(''), array('class' => 'btn btn btn-link btn-md')) !!}
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
@endsection