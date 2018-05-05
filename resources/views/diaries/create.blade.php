@extends ('main')

@section ('title', 'My Diary')

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
		<div class="col-md-8 col-md-offset-2">
			<h2>{{ Auth::user()->user_fname }} Diary</h2>
			<hr>
			{!! Form::open(array('route' => 'diaries.store', 'data-parsley-validate' => '', 'files' => true)) !!}
			
				{{ Form::label('title', 'Title: ') }}
				{{ Form::text('title', null, array('class' => 'form-control input-lg', 'required' => '')) }}

				{{ Form::label('cover_image', 'Cover Image', ['class' => 'margin-top-20']) }}
				{{ Form::file('cover_image', ['class' => 'form-control-file']) }}

				{{ Form::label('category_name', 'Category:', ['class' => 'margin-top-20']) }}
				<select class="form-control form-spacing-top-8" name="categories_id">
					
					@foreach ($categories as $category)
					<option value="{{ $category->id }}">{{ $category->category_name }}</option>
					@endforeach

				</select>

				{{ Form::label('tags', 'Tag: ', ['class' => 'margin-top-20']) }}
				<select class="form-control select2-multi form-spacing-top-8" name="tags[]" multiple="multiple">
					@foreach ($tags as $tag)
						<option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
					@endforeach
				</select>

				{{ Form::label('images', 'Content Images', ['class' => 'margin-top-20']) }}
				{{ Form::file('images[]', ['class' => 'form-control-file', 'multiple' => 'multiple']) }}
				
				{{ Form::label('message', 'Message: ', ['class' => 'margin-top-20']) }}
				{{ Form::textarea('message', null, array('class' => 'form-control input-lg', 'required' => '', 'rows' => '5')) }}
				
				{{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg form-spacing-top')) }}
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection

@section('scripts')
	{!! Html::script('js/select2.min.js') !!}

	<script type="text/javascript">
		$('.select2-multi').select2();
	</script>
@endsection