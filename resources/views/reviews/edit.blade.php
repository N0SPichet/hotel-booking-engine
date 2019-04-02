@extends ('main')
@section ('title', 'Edit review')
@section('stylesheets')
{{ Html::style('css/parsley.css') }}
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
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('rentals.show', $review->rental_id) }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-6 margin-auto">
		{!! Form::model($review, ['route' => ['reviews.update', $review->id], 'data-parsley-validate' => '', 'method' => 'PUT']) !!}

			{{ Form::label('name', 'Review as') }}
			{{ Form::text('name', Auth::user()->user_fname . " " . Auth::user()->user_lname, ['class' => 'form-control', 'required' => '', 'readonly' => '']) }}
			
			{{ Form::label('clean', 'Clean') }}
			<div class="star-rating" align="center">
				@for ($i = 5; $i > 0; $i--)
				<input type="radio" name="clean" value="{{$i}}" id="clean-{{$i}}" {!! $review->clean == $i ? 'checked' : '' !!} required>
				<label for="clean-{{$i}}" title="star {{$i}}"><i class="far fa-star"></i></label>
				@endfor
			</div>

			{{ Form::label('amenity', 'Amenity') }}
			<div class="star-rating" align="center">
				@for ($i = 5; $i > 0; $i--)
    			<input type="radio" name="amenity" value="{{$i}}" id="amenity-{{$i}}" {!! $review->amenity == $i ? 'checked' : '' !!} required>
				<label for="amenity-{{$i}}" title="star {{$i}}"><i class="far fa-star"></i></label>
				@endfor
			</div>

			{{ Form::label('service', 'Service') }}
			<div class="star-rating" align="center">
				@for ($i = 5; $i > 0; $i--)
    			<input type="radio" name="service" value="{{$i}}" id="service-{{$i}}" {!! $review->service == $i ? 'checked' : '' !!} required>
				<label for="service-{{$i}}" title="star {{$i}}"><i class="far fa-star"></i></label>
				@endfor
			</div>

			{{ Form::label('host', 'Host') }}
			<div class="star-rating" align="center">
				@for ($i = 5; $i > 0; $i--)
    			<input type="radio" name="host" value="{{$i}}" id="host-{{$i}}" {!! $review->host == $i ? 'checked' : '' !!} required>
    			<label for="host-{{$i}}" title="star {{$i}}"><i class="far fa-star"></i></label>
				@endfor
			</div>
				
			{{ Form::label('comment', 'Review') }}
			{{ Form::textarea('comment', $review->comment, ['class' => 'form-control', 'rows' => '5', 'required' => '']) }}

			{{ Form::submit('Save Changes', ['class' => 'btn btn-success m-t-20']) }}

		{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
@endsection
