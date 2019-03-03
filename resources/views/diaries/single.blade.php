@extends ('manages.main')
@section ('title', $diary->title. ' | ' .'My Diary')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			{!! Html::linkRoute('diaries.mydiaries', 'Back to My Diary', array($diary->user_id), array('class' => 'btn btn-outline-secondary')) !!}
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h1 class="text-center">{{ $diary->title }}</h1>
		</div>
		<div class="col-md-8 float-left">
			@if ($diary->cover_image != NULL)
			<div align="center">
				<img src="{{ asset('images/diaries/' . $diary->cover_image) }}" class="img-responsive" style="width: auto; height: 500px; border-radius: 1%">
			</div>
			@endif
			<div class="row">
				<div class="card m-t-10" style="width: 100%;">
					<div class="margin-content">
						<p> {!! $diary->message !!}</p>
					</div>
					<div class="gallery">
						@foreach ($diary->diary_images as $image)
						<div class="margin-content box diary">
							<div class="img-box">
								<a href="{{ asset('images/diaries/' . $image->image) }}"><img src="{{ asset('images/diaries/' . $image->image) }}" class="img-responsive" style="border-radius: 1%"></a>
								<a href="{{ route('diaries.detroyimage', $image->id)}}" class="btn btn-default btn-sm with-trash"><i class="fas fa-trash"></i></a>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
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
			<hr>
			<div class="row">
				<div class="col-md-12 m-t-50">
					@if ($diary->user->user_image == NULL)
					<div class="author-info">
						<img src="{{ asset('images/users/blank-profile-picture.png') }}" class="author-image">
						<div class="author-name">
							<h4>{{ $diary->user->user_fname }}</h4>
							<p class="author-time">Published on {{ date('jS F, Y', strtotime($diary->created_at)) }}</p>
						</div>
					</div>
					@else
					<div class="author-info">
						<img src="{{ asset('images/users/' . $diary->user->user_image) }}" class="author-image">
						<div class="author-name">
							<h4>{{ $diary->user->user_fname }}</h4>
							<p class="author-time">Published on {{ date('jS F, Y', strtotime($diary->created_at)) }}</p>
						</div>

					</div>
					@endif
				</div>
			</div>

			<div class="backend-comment m-t-50">
				<h3>Comments <small>{{ $diary->comments()->count() }} total</small></h3>
				@if($diary->comments()->count())
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
				@endif
			</div>
		</div>
		<div class="col-md-4 float-left">
			<div class="well">
				@if (Auth::user()->id == $diary->user_id)
				<div class="col-md-12" align="center">
					<div id="showPublish">
						@if ($diary->publish == '2')
						<p class="text-success m-t-20"><i class="fas fa-eye"></i> Subscriber only</p>
						@elseif ($diary->publish == '1')
						<p class="text-primary m-t-20"><i class="fas fa-eye"></i> Published</p>
						@elseif ($diary->publish == '0')
						<p class="text-danger m-t-20"><i class="fas fa-eye-slash"></i> Private</p>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 margin-auto" align="center">
						@if ($diary->publish != '3')
						<a href="{{ route('diaries.edit', $diary->id) }}" class="btn btn-outline-warning m-t-10"><i class="far fa-edit"></i> Edit</a>
						@else
						<a href="{{ route('diaries.restore', $diary->id) }}" class="btn btn-outline-warning m-t-10">Restore</a>
						@endif
					</div>
					<div class="col-md-12 margin-auto" align="center">
						@if ($diary->publish != '3')
						<a href="{{ route('diaries.temp.delete', $diary->id) }}" class="btn btn-danger m-t-10">Move to Trash</a>
						@else
						{!! Form::open(['route' => ['diaries.destroy', $diary->id], 'method' => 'DELETE']) !!}
						<button type="submit" class="btn btn-danger m-t-10"><i class="fas fa-trash"></i> Delete</button>
						{!! Form::close() !!}
						@endif
					</div>
					@if ($diary->publish != '3')
					<div class="margin-auto">
						<select id="publishFlag" class="form-control text-center m-t-20" type="select" name="flag">
							<option disabled="disabled">Select Viewer</option>
							<option value="2" {{ $diary->publish == '2' ? 'selected' : '' }}>Subscriber only</option>
							<option value="1" {{ $diary->publish == '1' ? 'selected' : '' }}>Public</option>
							<option value="0" {{ $diary->publish == '0' ? 'selected' : '' }}>Private</option>
						</select>
					</div>
					@endif
				</div>
				<hr>
				@endif
			</div>
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
				url: '{{ route('api.diaries.publish', $diary->id) }}',
				type: 'post',
				data: {
					flag:$( "#publishFlag option:selected" ).val()
				},
				dataType: 'json',
				success: function(response) {
					if (response.data == 2) {
						$('#showPublish').html('<p class="text-success m-t-20"><i class="fas fa-eye"></i> Subscriber only</p>')
					}
					else if(response.data == 1) {
						$('#showPublish').html('<p class="text-primary m-t-20"><i class="fas fa-eye"></i> Published</p>')
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