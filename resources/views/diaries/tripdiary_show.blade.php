@extends ('main')

@section ('title', $diaries[0]->title)

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<a href="{{ route('diaries.index') }}" class="btn btn-default"><i class="fas fa-chevron-left"></i> Back to Diaries</a>
		</div>
		<div class="col-md-12">
			<h2 class="text-center">
				@if($diaries[0]->title != 'Diary Title') {{ $diaries[0]->title }} @else 'Diary Title' @endif 
				@if ($diaries[0]->rentals_id != NULL)<small style="color: green;"><i class="far fa-check-circle"></i> granted trip</small>
				@else <small style="color: grey;"><i class="far fa-check-circle"></i> guide trip</small> @endif
			</h2>
			@if ($diaries[0]->cover_image)
			<div align="center">
				<a id="single_image" href="{{ asset('images/diaries/' . $diaries[0]->cover_image) }}"><img src="{{ asset('images/diaries/' . $diaries[0]->cover_image) }}" class="img-responsive" style="width: 600px; height: auto; border-radius: 1%"></a>
			</div>
			<div class="margin-content">
				<span class="text-left" style="font-size: 18px;">{!! $diaries[0]->message !!}</span>
			</div>
			@endif
			@for ($i = 1; $i <= $days ; $i++)
			<div class="panel panel-default col margin-top-20">
				<div class="panel-heading">
					<div class="text-center">
						<h2 class="diary_article__title">Day {{ $i }} <p class="trip-diary-time">{{ date('jS F, Y', strtotime($date[$i-1])) }}</p></h2>
					</div>
				</div>
				<div class="panel-body">
					{!! $diaries[$i]->message !!}
					@foreach ($diaries[$i]->diary_images as $image)
					<div class="col-md-3 col-sm-4">
						<a id="single_image" href="{{ asset('images/diaries/' . $image->image) }}"><img src="{{ asset('images/diaries/' . $image->image) }}" class="img-responsive margin-top-10" style="border-radius: 5%; "></a>
					</div>
					@endforeach
				</div>
			</div>
			@endfor
			<h3 class="text-center trip-diary-end">~~ End ~~</h3>
			<div class="row">
				<div class="col-md-10 margin-top-50">
					@if ($diaries[0]->users->user_image == NULL)
					<div class="author-info">
						<img src="{{ asset('images/users/blank-profile-picture.png') }}" class="author-image">
						<div class="author-name">
							<h4>{{ $diaries[0]->users->user_fname }}</h4>
							<p class="author-time">Published on {{ date('jS F, Y', strtotime($diaries[0]->created_at)) }}</p>
						</div>
					</div>
					@else
					<div class="author-info">
						<img src="{{ asset('images/users/' . $diaries[0]->users->user_image) }}" class="author-image">
						<div class="author-name">
							<h4>{{ $diaries[0]->users->user_fname }}</h4>
							<p class="author-time">Published on {{ date('jS F, Y', strtotime($diaries[0]->created_at)) }}</p>
						</div>

					</div>
					@endif
				</div>
				<div class="col-md-2  margin-top-50">
					@if (Auth::check())
						@if ($subscribe)
							@if ($subscribe->writer == Auth::user()->id)

							@elseif ($subscribe->writer != Auth::user()->id)
							{!! Form::open(['route'=> ['diary.unsubscribe', $diaries[0]->users->id]]) !!}
							<button class="btn btn-info btn-sm margin-top-50 pull-right">Unfollow {{ $diaries[0]->users->user_fname }}</button>
							{!! Form::close() !!}
							@endif
						@else
						{!! Form::open(['route'=> ['diary.subscribe', $diaries[0]->users->id]]) !!}
						<button class="btn btn-info btn-sm margin-top-50 pull-right">Follow {{ $diaries[0]->users->user_fname }}</button>
						{!! Form::close() !!}
						@endif
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			@if ($diaries[0]->comments()->count() != 0)
			<h3 class="comment-title"><i class="far fa-comments"></i> {{ $diaries[0]->comments()->count() }} Comments</h3>
			@elseif ($diaries[0]->comments()->count() == 0)
			<h3 class="comment-title"><i class="far fa-comments"></i> {{ $diaries[0]->comments()->count() }} Comment</h3>
			@endif

			@foreach ($diaries[0]->comments as $comment)
			<div class="card margin-top-10">
				<div class="margin-content">
					<div class="col-md-11">
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
					<div class="col-md-1">
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
		<div id="comment-form" class="margin-top-50">
			{!! Form::open(['route' => 'comments.store','data-parsley-validate']) !!}
				<div class="row">
					<div class="col-md-6">
						{{ Form::hidden('diary_id', $diaries[0]->id) }}

						{{ Form::label('name', 'Name:') }}
						@if (Auth::check())
						{{ Form::text('name', Auth::user()->user_fname. ' ' .Auth::user()->user_lname, ['class' => 'form-control', 'required' => '', 'readonly' => '']) }}
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