@extends ('main')
@section ('title', $diaries[0]->title. ' | ' .'My Diary')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			{!! Html::linkRoute('diaries.mydiaries', 'Back to My Diary', array($diaries[0]->user_id), array('class' => 'btn btn-outline-secondary')) !!}
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h1 class="title-page">@if($diaries[0]->title != 'Diary Title') {{ $diaries[0]->title }} @else 'Diary Title' @endif</h1>
			<div class="text-center">
				@if ($diaries[0]->cover_image != NULL)
				<div class="col-md-2 col-sm-2 float-left">
					
				</div>
				<div class="col-md-8 col-sm-8 float-left">
					<div align="center">
						<a href="{{ asset('images/diaries/' . $diaries[0]->cover_image) }}"><img src="{{ asset('images/diaries/' . $diaries[0]->cover_image) }}" class="img-responsive" style="width: 600px; height: auto; border-radius: 1%"></a>
					</div>
				</div>
				<div class="col-md-2 col-sm-2 float-left">
				@else
				<div class="col-md-12 col-sm-12">
				@endif
					<div id="showPublish">
						@if ($diaries[0]->publish == '2')
						<p class="text-success m-t-20"><i class="fas fa-eye"></i> Published</p>
						@elseif ($diaries[0]->publish == '1')
						<p class="text-primary m-t-20"><i class="fas fa-eye"></i> Follower</p>
						@elseif ($diaries[0]->publish == '0')
						<p class="text-danger m-t-20"><i class="fas fa-eye-slash"></i> Private</p>
						@endif
					</div>
					<p><a href="{{ route('diaries.tripdiary.edit', [$rental->id, $rental->user_id, 0])}}" class="btn btn-default btn-md" style="width: 90%"><i class="far fa-edit"></i> Edit Topic</a></p>
					<p><a href="{{ route('diaries.tripdiary.destroy', [$rental->id]) }}" class="btn btn-default btn-md" style="width: 90%"><i class="fas fa-trash"></i> Delete Diary</a></p>
					<select id="publishFlag" class="form-control margin-auto" type="select" name="flag" style="width: 120px;">
						<option disabled="disabled">Select Viewer</option>
						<option value="2" {{ $diaries[0]->publish == '2' ? 'selected' : '' }}>Public</option>
						<option value="1" {{ $diaries[0]->publish == '1' ? 'selected' : '' }}>Follower</option>
						<option value="0" {{ $diaries[0]->publish == '0' ? 'selected' : '' }}>Private</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 m-t-10">
			<div class="margin-content">
				<span class="text-left" style="font-size: 18px;">{!! $diaries[0]->message !!}</span>
			</div>
		</div>
		<div class="col-md-12 m-t-20">
		@for ($i = 1; $i <= $days ; $i++)
		<div class="well m-t-10">
			<h2 class="text-center">Day {{ $i }} <a href="{{ route('diaries.tripdiary.edit', [$rental->id, $rental->user_id, $i])}}" class="btn btn-default btn-md pull-right"><i class="far fa-edit"></i></a></h2>
			<h2 class="text-center"><p class="trip-diary-time" style="margin-left: -45px;">{{ date('jS F, Y', strtotime($date[$i-1])) }}</p></h2>
			<div>
				<p>{!! $diaries[$i]->message !!}</p>
			</div>
			<div class="row">
				@foreach ($diaries[$i]->diary_images as $image)
				<div id="image{{$image->id}}" class="col-md-3">
					<a href="{{ asset('images/diaries/' . $image->image) }}"><img src="{{ asset('images/diaries/' . $image->image) }}" class="img-responsive m-t-10" style="border-radius: 2%; "></a>
					<a id="deleteDiaryImage" href="{{ route('diaries.detroyimage', $image->id)}}"  class="btn btn-default btn-md with-trash"><i class="fas fa-trash"></i></a>
				</div>
				@endforeach
			</div>
		</div>
		@endfor
		</div>
	</div>
	<hr>
	<div class="m-t-10">
		<b>Category :</b> {{ $diaries[0]->category->name }}
	</div>
	@if($diaries[0]->tags->count())
	<?php
	$tag_length = $diaries[0]->tags->count();
	?>
	<div class="tags">
		<b>Tag :</b>
		@foreach ($diaries[0]->tags as $key => $tag)
		<span class="label label-default">{{ $tag->name }}</span>
		@if($key+1 != $tag_length)
		,
		@endif
		@endforeach
	</div>
	@endif
	<hr>
	<div class="row">
		<div class="col-md-12 m-t-50">
			@if ($diaries[0]->user->user_image == NULL)
			<div class="author-info">
				<img src="{{ asset('images/users/blank-profile-picture.png') }}" class="author-image">
				<div class="author-name">
					<h4>{{ $diaries[0]->user->user_fname }}</h4>
					<p class="author-time">Published on {{ date('jS F, Y', strtotime($diaries[0]->created_at)) }}</p>
				</div>
			</div>
			@else
			<div class="author-info">
				<img src="{{ asset('images/users/' . $diaries[0]->user->user_image) }}" class="author-image">
				<div class="author-name">
					<h4>{{ $diaries[0]->user->user_fname }}</h4>
					<p class="author-time">Published on {{ date('jS F, Y', strtotime($diaries[0]->created_at)) }}</p>
				</div>
			</div>
			@endif
		</div>
	</div>

	<div class="row">
		<div class="backend-comment m-t-50">
			<h3>Comments <small>{{ $diaries[0]->comments()->count() }} total</small></h3>
			@if($diaries[0]->comments()->count())
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
			@endif
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$.ajaxSetup({
		        headers:
		        {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });
		$('#publishFlag').on('change', function(event) {
			$.ajax({
				url: '{{ route('api.diaries.publish', $diaries[0]->id) }}',
				type: 'post',
				data: {
					flag:$( "#publishFlag option:selected" ).val()
				},
				dataType: 'json',
				success: function(response) {
					if (response.data == 2) {
						$('#showPublish').html('<p class="text-success m-t-20"><i class="fas fa-eye"></i> Published</p>')
					}
					else if(response.data == 1) {
						$('#showPublish').html('<p class="text-primary m-t-20"><i class="fas fa-eye"></i> Follower</p>')
					}
					else if(response.data == 0) {
						$('#showPublish').html('<p class="text-danger m-t-20"><i class="fas fa-eye-slash"></i> Private</p>')
					}
				}
			});
		});
	});
</script>
@endsection