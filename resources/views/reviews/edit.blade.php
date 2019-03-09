@extends ('main')
@section ('title', 'Edit review')
@section('stylesheets')
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=qei14aeigd6p0lkquybi330fte0vp7ne9ullaou6d5ti437y"></script>
<script>
	tinymce.init({ 
		selector:'textarea',
		menubar: false
	});
</script>
@endsection

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<a href="{{ route('rentals.show', $review->rental_id) }}" class="btn btn-default"><i class="fas fa-chevron-left"></i> Back to Diaries</a>
		</div>
		<div class="col-md-10 col-md-offset-1">
		{!! Form::model($review, ['route' => ['reviews.update', $review->id], 'method' => 'PUT']) !!}

			{{ Form::label('name', 'Review as') }}
			{{ Form::text('name', Auth::user()->user_fname . " " . Auth::user()->user_lname, ['class' => 'form-control', 'required' => '', 'readonly' => '']) }}
			
			{{ Form::label('clean', 'Clean') }}
			<div class="star-rating" align="center">
				@for ($i = 5; $i > 0; $i--)
				<input type="radio" name="clean" value="{{$i}}" id="clean-{{$i}}" {{ $review->clean == $i ? 'checked' : '' }}>
				<label for="clean-{{$i}}" title="star {{$i}}"><i class="far fa-star"></i></label>
				@endfor
			</div>

			{{ Form::label('amenity', 'Amenity') }}
			<div class="star-rating" align="center">
				@for ($i = 5; $i > 0; $i--)
    			<input type="radio" name="amenity" value="{{$i}}" id="amenity-{{$i}}" {{ $review->amenity == $i ? 'checked' : '' }}>
				<label for="amenity-{{$i}}" title="star {{$i}}"><i class="far fa-star"></i></label>
				@endfor
			</div>

			{{ Form::label('service', 'Service') }}
			<div class="star-rating" align="center">
				@for ($i = 5; $i > 0; $i--)
    			<input type="radio" name="service" value="{{$i}}" id="service-{{$i}}" {{ $review->service == $i ? 'checked' : '' }}>
				<label for="service-{{$i}}" title="star {{$i}}"><i class="far fa-star"></i></label>
				@endfor
			</div>

			{{ Form::label('host', 'Host') }}
			<div class="star-rating" align="center">
				@for ($i = 5; $i > 0; $i--)
    			<input type="radio" name="host" value="{{$i}}" id="host-{{$i}}" {{ $review->host == $i ? 'checked' : '' }}>
    			<label for="host-{{$i}}" title="star {{$i}}"><i class="far fa-star"></i></label>
				@endfor
			</div>
				
			{{ Form::label('room_comment', 'Review') }}
			{{ Form::textarea('room_comment', $review->room_comment, ['class' => 'form-control', 'rows' => '5']) }}

			{{ Form::submit('Save Changes', ['class' => 'btn btn-success m-t-20']) }}

		{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection