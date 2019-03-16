@extends ('main')
@section ('title', $diary->title.' | '.$diary->user->user_fname. ' | ' .'Diary')
@section('stylesheets')
{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('diaries.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Explore diaries</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-12">
			<div class="text-center">
				<h2>{{ $diary->title }}</h2>
			</div>
			@if ($diary->cover_image != NULL)
			<div align="center">
				<img src="{{ asset('images/diaries/' . $diary->cover_image) }}" class="img-responsive" style="width: auto; height: 500px; border-radius: 1%">
			</div>
			@endif
			<p> {!! $diary->message !!}</p>
			<hr>
			@if ($diary->diary_images != NULL)
			<div class="row">
				<div class="gallery">
					@foreach ($diary->diary_images as $image)
					<div class="margin-content box diary">
						<div class="img-box">
							<a href="{{ asset('images/diaries/' . $image->image) }}"><img src="{{ asset('images/diaries/' . $image->image) }}" class="img-responsive" style="border-radius: 1%"></a>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			@endif
			<div class="m-t-10">
				<b>Category :</b> {{ $diary->category->name }}
			</div>
			@if($diary->tags->count())
			<?php
			$tag_length = $diary->tags->count();
			?>
			<hr>
			<div class="tags">
				<b>Tag :</b>
				@foreach ($diary->tags as $key => $tag)
					<span class="label label-default">{{ $tag->name }}</span>
					@if($key+1 != $tag_length)
					,
					@endif
				@endforeach
			</div>
			@endif
			<div class="row">
				<div class="col-md-10 m-t-10">
					@if ($diary->user->user_image == NULL)
					<div class="author-info">
						<a target="_blank" href="{{route('users.show', $diary->user_id)}}"><img src="{{ asset('images/users/blank-profile-picture.png') }}" class="author-image"></a>
						<div class="author-name">
							<a target="_blank" href="{{route('users.show', $diary->user_id)}}"><h4>{{ $diary->user->user_fname }}</h4>
							<p class="author-time">Published on {{ date('jS F, Y', strtotime($diary->created_at)) }} (last update {{ $diary->updated_at->diffForHumans() }})</p></a>
						</div>
					</div>
					@else
					<div class="author-info">
						<a target="_blank" href="{{route('users.show', $diary->user_id)}}"><img src="{{ asset('images/users/'.$diary->user_id.'/'.$diary->user->user_image) }}" class="author-image"></a>
						<div class="author-name">
							<a target="_blank" href="{{route('users.show', $diary->user_id)}}"><h4>{{ $diary->user->user_fname }}</h4>
							<p class="author-time">Published on {{ date('jS F, Y', strtotime($diary->created_at)) }}</p></a>
						</div>

					</div>
					@endif
				</div>
				<div class="col-md-2 float-left text-center m-t-10 m-b-10">
					@if (Auth::check())
					@if (Auth::user()->subscribe($diary->id))
						@if (Auth::user()->subscribe($diary->id)->writer == Auth::user()->id)

						@else
						{!! Form::open(['route'=> ['diaries.unsubscribe', $diary->user_id]]) !!}
						<button class="btn btn-warning btn-sm m-t-50 pull-right">Unfollow {{ $diary->user->user_fname }}</button>
						{!! Form::close() !!}
						@endif
					@else
					{!! Form::open(['route'=> ['diaries.subscribe', $diary->user_id]]) !!}
					<button class="btn btn-info btn-sm pull-right">Follow {{ $diary->user->user_fname }}</button>
					{!! Form::close() !!}
					@endif
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			@if ($diary->comments()->count() != 0)
			<h3 class="comment-title"><i class="far fa-comments"></i> {{ $diary->comments()->count() }} Comments</h3>
			@elseif ($diary->comments()->count() == 0)
			<h3 class="comment-title"><i class="far fa-comments"></i> {{ $diary->comments()->count() }} Comment</h3>
			@endif

			@foreach ($diary->comments as $comment)
			<div class="card m-t-10">
				<div class="margin-content">
					<div class="col-md-11 float-left">
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
					</div>
					<div class="col-md-1 float-left">
						@if (Auth::check())
						@if (Auth::user()->email == $comment->email)
						{!! Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'DELETE', 'style'=>'display:inline']) !!}
							<button type="submit" class="btn btn-default btn-sm"><i class="fas fa-trash"></i></button>
						{!! Form::close() !!}
						@endif
						@endif
					</div>
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
		<div id="comment-form" class="margin-auto m-t-50">
			{!! Form::open(['route' => 'comments.store','data-parsley-validate']) !!}
				<div class="col-md-6">
					{{ Form::hidden('diary_id', $diary->id) }}

					{{ Form::label('name', 'Name:') }}
					@if (Auth::check())
					{{ Form::text('name', Auth::user()->user_fname, ['class' => 'form-control', 'required' => '', 'readonly' => '']) }}
					@else
					{{ Form::text('name', null, ['class' => 'form-control', 'required' => '']) }}
					@endif
				</div>
				<div class="col-md-6">
					@if (Auth::check())
					<br><br>
					<p style="color: red;">login as {{ Auth::user()->user_fname }}</p>
					{{ Form::hidden('email', Auth::user()->email) }}
					@else
					{{ Form::label('email', 'Email:') }}
					{{ Form::text('email', null, ['class' => 'form-control', 'required' => '']) }}
					@endif
				</div>
				<div class="col-md-12">
					{{ Form::label('comment', 'Comment:') }}
					{{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5', 'required' => '']) }}

					{{ Form::submit('Add comment', ['class' => 'btn btn-success pull-right form-spacing-top-8']) }}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function() {

			/* This is basic - uses default settings */
			
			$("a#single_image").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	200, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
			});
			
			/* Using custom settings */
			
			$("a#inline").fancybox({
				'hideOnContentClick': true
			});

			/* Apply fancybox to multiple items */
			
			$("a.group").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
			});
		});
	</script>
@endsection
