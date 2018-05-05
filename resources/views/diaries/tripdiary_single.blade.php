@extends ('main')

@section ('title', $diaries[0]->title. ' | ' .'My Diary')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="title-page">@if($diaries[0]->title != 'Diary Title') {{ $diaries[0]->title }} @else 'Diary Title' @endif</h1>
			<div class="text-center">
				@if ($diaries[0]->cover_image != NULL)
				<div class="col-md-2 col-sm-2">
					
				</div>
				<div class="col-md-8 col-sm-8">
					<div align="center">
						<a id="single_image" href="{{ asset('images/diaries/' . $diaries[0]->cover_image) }}"><img src="{{ asset('images/diaries/' . $diaries[0]->cover_image) }}" class="img-responsive" style="width: 600px; height: auto; border-radius: 1%"></a>
					</div>
				</div>
				<div class="col-md-2 col-sm-2">
				@else
				<div class="col-md-12 col-sm-12">
				@endif
					<p><a href="{{ route('tripdiary_edit', [$rental->id, 0])}}" class="btn btn-default btn-md" style="width: 90%"><i class="far fa-edit"></i> Edit Topic</a></p>
					<p><a href="{{ route('tripdiary_destroy', [$rental->id]) }}" class="btn btn-default btn-md" style="width: 90%"><i class="fas fa-trash"></i> Delete Diary</a></p>
					@if ($diaries[0]->publish == '2')
					<p class="text-success margin-top-20"><i class="fas fa-eye"></i> Published</p>
					@elseif ($diaries[0]->publish == '1')
					<p class="text-primary margin-top-20"><i class="fas fa-eye"></i> Follower</p>
					@elseif ($diaries[0]->publish == '0')
					<p class="text-danger margin-top-20"><i class="fas fa-eye-slash"></i> Private</p>
					@endif
				</div>
				
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 margin-top-10">
			<div class="margin-content">
				<span class="text-left" style="font-size: 18px;">{!! $diaries[0]->message !!}</span>
			</div>
		</div>
		<div class="col-md-12 margin-top-20">
		@for ($i = 1; $i <= $days ; $i++)
		<div class="well">
			<h2 class="text-center">Day {{ $i }} <a href="{{ route('tripdiary_edit', [$rental->id, $i])}}" class="btn btn-default btn-md pull-right"><i class="far fa-edit"></i></a></h2>
			<h2 class="text-center"><p class="trip-diary-time" style="margin-left: -45px;">{{ date('jS F, Y', strtotime($date[$i-1])) }}</p></h2>
			<div>
				<p>{!! $diaries[$i]->message !!}</p>
			</div>
			<div class="row">
				@foreach ($diaries[$i]->diary_images as $image)
				<div class="col-md-3">
					<a id="single_image" href="{{ asset('images/diaries/' . $image->image) }}"><img src="{{ asset('images/diaries/' . $image->image) }}" class="img-responsive margin-top-10" style="border-radius: 5%; "></a>
					<a href="{{ route('diaries.detroyimage', $image->id)}}" style="position: relative; top:-160px; left: 190px;" class="btn btn-default btn-md"><i class="fas fa-trash"></i></a>
				</div>
				@endforeach
			</div>
		</div>
		@endfor
		</div>
	</div>

	<div class="tags">
		@foreach ($diaries[0]->tags as $tag)
		<span class="label label-default">{{ $tag->tag_name }}</span>
		@endforeach
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12 margin-top-50">
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
	</div>

	<div class="row">
		<div class="backend-comment margin-top-50">
			<h3>Comments <small>{{ $diaries[0]->comments()->count() }} total</small></h3>
			<table class="table">
				<thead>
					<tr>
						<th style="width: 20%">Name</th>
						<th style="width: 20%">Email</th>
						<th style="width: 50%">Comment</th>
						<th style="width: 10%"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($diaries[0]->comments as $comment)
					<tr>
						<td>{{ $comment->name }}</td>
						<td>{{ $comment->email }}</td>
						<td>{{ $comment->comment }}</td>
						<td>
							<a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary"><i class="far fa-edit"></i></a>
							<a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this comment?');"><i class="fas fa-trash"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
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