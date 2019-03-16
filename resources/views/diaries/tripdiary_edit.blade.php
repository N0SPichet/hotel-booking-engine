@extends ('dashboard.main')
@section ('title', 'Edit Trip Diary '. ($day != '0' ? 'Day '.$day: ''))
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
<div class="container diaries">
	<div class="row m-t-10">
		<div class="col">
			{!! Form::model($diary, ['route' => ['diaries.tripdiary.update', $diary->id ], 'data-parsley-validate' => '', 'method' => 'PUT', 'files' => true]) !!}
			<div class="col-md-9 float-left">
				@if ($day != 0)
				<h4>{{ $diary_title }} day {{ $day }}</h4>
				@else
				{{ Form::label('title', 'Title:') }}
				{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', "data-parsley-trigger"=>"keyup", "data-parsley-minlength"=>"8", "data-parsley-maxlength"=>"100", "data-parsley-minlength-message"=>"Title should be 8 characters long."]) }}

				{{ Form::label('category_id', 'Category:', ['class' => 'form-spacing-top']) }}
				<select class="form-control form-spacing-top-8" name="category_id">
					<option value="0" disabled="">Select category</option>
					@foreach ($categories as $category)
					<option value="{{ $category->id }}" {{ $diary->category_id==$category->id? 'selected':'' }}>{{ $category->name }}</option>
					@endforeach
				</select>

				{{ Form::label('tags', 'Tag: ', ['class' => 'form-spacing-top']) }}
				<div class="row ">
					@foreach ($tags as $tag)
					<div class="col-md-6 col-sm-6 float-left" >
						{{ Form::checkbox('tags[]', $tag->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "tag$tag->id"]) }}
						{{ Form::label('tag' . $tag->id, $tag->name) }}
					</div>
					@endforeach
				</div>

				{{ Form::label('cover_image', 'Cover image: ', ['class' => 'form-spacing-top']) }}
				{{ Form::file('cover_image', ['class' => 'form-control form-spacing-top-8']) }}
				@endif
				@if ($day != 0)
				{{ Form::label('images', 'Image: ', ['class' => 'form-spacing-top']) }}
				{{ Form::file('images[]', ['class' => 'form-control-file', 'multiple' => 'multiple']) }}
				@endif
				{{ Form::label('message', 'Body:', ['class' => 'form-spacing-top']) }}
				{{ Form::textarea('message', null, ['class' => 'form-control', 'rows' => '5', 'required' => '', "data-parsley-trigger"=>"keyup", "data-parsley-minlength"=>"32", "data-parsley-maxlength"=>"500", "data-parsley-minlength-message"=>"Title should be 32 characters long."]) }}
			</div>
			<div class="col-md-3 float-left m-t-20">
				<div class="col-sm-6 float-left">
				{!! Html::linkRoute('diaries.tripdiary', 'Cancel', array($diary->rental_id, $diary->rental->user_id), array('class' => 'btn btn-danger btn-block m-t-20')) !!}
				</div>

				<div class="col-sm-6 float-left">
				{{ Form::submit('Save Changes', ['class' => 'btn btn-success m-t-20']) }}
				</div>
			</div>
			{!! Form::close() !!}
		</div>
		
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
@endsection
