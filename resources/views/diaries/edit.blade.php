@extends ('manages.main')
@section ('title', 'Edit Diary')
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

		{!! Form::model($diary, ['route' => ['diaries.update', $diary->id], 'method' => 'PUT', 'files' => true]) !!}
			{{ csrf_field() }}
		<div class="col-md-8 col-sm-8 float-left">
			{{ Form::label('title', 'Title:') }}
			{{ Form::text('title', null, ['class' => 'form-control']) }}

			{{ Form::label('cover_image', 'Cover Image', ['class' => 'm-t-20']) }}
			{{ Form::file('cover_image', ['class' => 'form-control-file']) }}

			{{ Form::label('select_cover_image', 'Select from Content Images', ['class' => 'm-t-20']) }}
			<div class="row">
				@foreach ($diary->diary_images as $index => $diaryimage)
				<div class="col-md-3 margin-content">
					<div class="form-check">
		  			<input class="form-check-input" type="radio" name="select_cover_image" id="{{ $index }}" value="{{ $diaryimage->image }}" {{ $diaryimage->image == $diary->cover_image ? 'checked'  : '' }}>
					<label class="form-check-label" for="{{ $index }}">
			   			<img src="{{ asset('images/diaries/' . $diaryimage->image) }}" class="img-responsive" style="width: 100%;">
					</label>
					</div>
				</div>
				@endforeach
			</div>

			{{ Form::label('category_id', 'Category:', ['class' => 'm-t-20']) }}
			<select class="form-control form-spacing-top-8" name="category_id">
				@foreach ($categories as $category)
				<option value="{{ $category->id }}" {{ $diary->category_id==$category->id? 'selected':'' }}>{{ $category->name }}</option>
				@endforeach
			</select>

			{{ Form::label('tags', 'Tag: ', ['class' => 'm-t-20']) }}
			<div class="row ">
				@foreach ($tags as $tag)
				<div class="col" >
					{{ Form::checkbox('tags[]', $tag->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "tag$tag->id"]) }}
					{{ Form::label('tag' . $tag->id, $tag->name) }}
				</div>
				@endforeach
			</div>

			{{ Form::label('images', 'Content Images', ['class' => 'm-t-20']) }}
			{{ Form::file('images[]', ['class' => 'form-control-file', 'multiple' => 'multiple']) }}

			{{ Form::label('message', 'Message:', ['class' => 'm-t-20']) }}
			{{ Form::textarea('message', null, ['class' => 'form-control', 'rows' => '5']) }}
		</div>

		<div class="col-md-4 col-sm-4 float-left">
			<div class="col-sm-6 float-left">
			<a href="{{ route('diaries.single', $diary->id) }}" class="btn btn-outline-secondary m-t-10" style="width: 100%;">Cancel</a>
			</div>
			<div class="col-sm-6 float-left">
			{{ Form::submit('Save Changes', ['class' => 'btn btn-success m-t-10']) }}
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
@endsection