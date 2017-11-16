@extends ('main')

@section ('title', $diary->users->user_fname. ' | ' .'All Diary')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<a href="{{ URL::previous() }}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-chevron-left"></span>Back to Diaries</a>
		</div>
		<div class="col-md-12">
			<h2>{{ $diary->title }}</h2>
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
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			@if ($diary->comments()->count() != 0)
			<h3 class="comment-title"><span class="glyphicon glyphicon-comment"></span> {{ $diary->comments()->count() }} Comments</h3>
			@elseif ($diary->comments()->count() == 0)
			<h3 class="comment-title"><span class="glyphicon glyphicon-comment"></span> {{ $diary->comments()->count() }} Comment</h3>
			@endif

			@foreach ($diary->comments as $comment)
			<div class="comment">
				<div class="author-info">
					<img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($comment->email))) . '?s=50&d=monsterid' }}" class="author-image">
					<div class="author-name">
						<h4>{{ $comment->name }}</h4>
						<p class="author-time">{{ date('jS F, Y - g:iA', strtotime($comment->created_at)) }}</p>
					</div>
				</div>
				<div class="comment-content">
					{{ $comment->comment }}
				</div>
			</div>
			@endforeach
		</div>
	</div>

	<div class="row">
			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
		<div id="comment-form" style="margin-top: 50px;">
			{!! Form::open(['route' => 'comments.store']) !!}
				<div class="row">
					<div class="col-md-6">
						{{ Form::hidden('diary_id', $diary->id) }}

						{{ Form::label('name', 'Name:') }}
						{{ Form::text('name', null, ['class' => 'form-control']) }}
					</div>
					<div class="col-md-6">
						{{ Form::label('email', 'Email:') }}
						{{ Form::text('email', null, ['class' => 'form-control']) }}
					</div>
					<div class="col-md-12">
						{{ Form::label('comment', 'Comment:') }}
						{{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}

						{{ Form::submit('Add comment', ['class' => 'btn btn-success pull-right form-spacing-top-8']) }}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection