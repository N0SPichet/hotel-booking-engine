@extends ('main')

@section ('title', $diary->title. ' | ' .'My Diary')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="text-center">{{ $diary->title }}</h1>
		</div>
			<div class="col-md-8">
				@if ($diary->cover_image != NULL)
				<div align="center">
					<img src="{{ asset('images/diaries/' . $diary->cover_image) }}" class="img-responsive" style="width: auto; height: 500px; border-radius: 1%">
				</div>
				@endif
				<div class="row">
					<div class="card margin-top-10" style="width: 100%;">
						<div class="margin-content">
							<p> {!! $diary->message !!}</p>
						</div>
						<div class="gallery">
							@foreach ($diary->diary_images as $image)
							<div class="col-md-3 col-sm-3" style="margin-top: 10px; margin-bottom: 10px;">
								<a id="single_image" href="{{ asset('images/diaries/' . $image->image) }}"><img src="{{ asset('images/diaries/' . $image->image) }}" class="img-responsive" style="border-radius: 1%"></a>
								<a href="{{ route('diaries.detroyimage', $image->id)}}" style="position: absolute; top:2px; right: : 2px; z-index: 100;" class="btn btn-default btn-sm"><i class="fas fa-trash"></i></a>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				<hr>
				<div class="tags">
					@foreach ($diary->tags as $tag)
					<span class="label label-default">{{ $tag->tag_name }}</span>
					@endforeach
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12 margin-top-50">
						@if ($diary->users->user_image == NULL)
						<div class="author-info">
							<img src="{{ asset('images/users/blank-profile-picture.png') }}" class="author-image">
							<div class="author-name">
								<h4>{{ $diary->users->user_fname }}</h4>
								<p class="author-time">Published on {{ date('jS F, Y', strtotime($diary->created_at)) }}</p>
							</div>
						</div>
						@else
						<div class="author-info">
							<img src="{{ asset('images/users/' . $diary->users->user_image) }}" class="author-image">
							<div class="author-name">
								<h4>{{ $diary->users->user_fname }}</h4>
								<p class="author-time">Published on {{ date('jS F, Y', strtotime($diary->created_at)) }}</p>
							</div>

						</div>
						@endif
					</div>
				</div>

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
									<a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary"><i class="far fa-edit"></i></a>
									<a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this comment?');"><i class="fas fa-trash"></i></a>
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
						<p><b>Category :</b> {{ $diary->categories->category_name }}</p>
					</div>
					@if ($diary->users_id == Auth::user()->id)
					<div class="row">
						<div class="col-md-6 col-sm-12" align="center">
							<a href="{{ route('diaries.edit', $diary->id) }}" class="btn btn-primary btn-block btn-h1-spacing"><i class="far fa-edit"></i> Edit</a>
						</div>
						<div class="col-md-6 col-sm-12" align="center">
							{!! Form::open(['route' => ['diaries.destroy', $diary->id], 'method' => 'DELETE']) !!}
							<button type="submit" class="btn btn-danger btn-block btn-h1-spacing"><i class="fas fa-trash"></i> Delete</button>
							{!! Form::close() !!}
						</div>
						<div class="col-md-6 col-sm-6" align="center">
							@if ($diary->publish == '2')
							<p class="text-success margin-top-20"><i class="fas fa-eye"></i> Published</p>
							@elseif ($diary->publish == '1')
							<p class="text-primary margin-top-20"><i class="fas fa-eye"></i> Follower</p>
							@elseif ($diary->publish == '0')
							<p class="text-danger margin-top-20"><i class="fas fa-eye-slash"></i> Private</p>
							@endif
						</div>
					</div>
					<hr>
					@endif
					
					<div class="row">
						<div class="col-sm-6">
							{!! Html::linkRoute('diaries.mydiaries', 'Back to My Diary', array(''), array('class' => 'btn btn-outline-secondary')) !!}
						</div>
					</div>
				</div>
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