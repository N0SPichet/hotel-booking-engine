@extends ('main')

@section ('title', 'Edit Diary')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
	{!! Html::style('css/select2.min.css') !!}
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

		{!! Form::model($diary, ['route' => ['diaries.update', $diary->id], 'method' => 'PUT', 'files' => true]) !!}
			{{ csrf_field() }}
		<div class="col-md-8 col-sm-8">
			{{ Form::label('title', 'Title:') }}
			{{ Form::text('title', null, ['class' => 'form-control']) }}

			{{ Form::label('cover_image', 'Cover Image', ['class' => 'margin-top-20']) }}
			{{ Form::file('cover_image', ['class' => 'form-control-file']) }}

			{{ Form::label('select_cover_image', 'Select from Content Images', ['class' => 'margin-top-20']) }}
			<div class="row">
				@foreach ($diary->diary_images as $index => $diaryimage)
				<div class="col-md-3">
					<div class="form-check">
		  			<input class="form-check-input" type="radio" name="select_cover_image" id="{{ $index }}" value="{{ $diaryimage->image }}" {{ $diaryimage->image == $diary->cover_image ? 'checked'  : '' }}>
					<label class="form-check-label" for="{{ $index }}">
			   			<img src="{{ asset('images/diaries/' . $diaryimage->image) }}" class="img-responsive" style="width: 100%;">
					</label>
					</div>
				</div>
				@endforeach
			</div>

			{{ Form::label('categories_id', 'Category:', ['class' => 'margin-top-20']) }}
			{{ Form::select('categories_id', $categories, null, ['class' => 'form-control']) }}

			{{ Form::label('tags', 'Tag: ', ['class' => 'margin-top-20']) }}
			{{ Form::select('tags[]', $tags, null, ['class' => 'form-control select2-multi margin-top-10', 'multiple' => 'multiple']) }}

			{{ Form::label('images', 'Content Images', ['class' => 'margin-top-20']) }}
			{{ Form::file('images[]', ['class' => 'form-control-file', 'multiple' => 'multiple']) }}

			{{ Form::label('message', 'Message:', ['class' => 'margin-top-20']) }}
			{{ Form::textarea('message', null, ['class' => 'form-control', 'rows' => '5']) }}
		</div>

		<div class="col-md-4 col-sm-4">
			<div class="col-md-12 col-sm-12" align="center">
			{{ Form::label('publish', 'Who see this diary?', ['class' => 'margin-top-10']) }}
			<select name="publish" class="form-control margin-top-10" style="width: 100%;">
					<option value="2" {{ $diary->publish == '2' ? 'selected' : '' }}>Public</option>
					<option value="1" {{ $diary->publish == '1' ? 'selected' : '' }}>Follower</option>
					<option value="0" {{ $diary->publish == '0' ? 'selected' : '' }}>Private</option>
			</select>
			</div>
			<div class="col-sm-6">
			<a href="{{ route('diary.single', $diary->id) }}" class="btn btn-danger margin-top-10" style="width: 100%;">Cancel</a>
			</div>
			<div class="col-sm-6">
			{{ Form::submit('Save Changes', ['class' => 'btn btn-success margin-top-10']) }}
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
	{!! Html::script('js/select2.min.js') !!}

	<script type="text/javascript">
		$('.select2-multi').select2();
		
	</script>
@endsection