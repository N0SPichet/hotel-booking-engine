@extends ('main')

@section ('title', 'My Diary | Create')

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
		<div class="col-md-8 float-left" style="margin: auto;">
			<h2>{{ Auth::user()->user_fname }} Diary</h2>
			<hr>
			{!! Form::open(array('route' => 'diaries.store', 'data-parsley-validate' => '', 'files' => true)) !!}
			
				{{ Form::label('title', 'Title: ') }}
				{{ Form::text('title', null, array('class' => 'form-control input-lg', 'required' => '')) }}

				{{ Form::label('cover_image', 'Cover Image', ['class' => 'm-t-20']) }}
				{{ Form::file('cover_image', ['class' => 'form-control-file']) }}

				{{ Form::label('category_name', 'Category:', ['class' => 'm-t-20']) }}
				<select class="form-control form-spacing-top-8" name="categories_id">
					@foreach ($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
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
				
				{{ Form::label('message', 'Message: ', ['class' => 'm-t-20']) }}
				{{ Form::textarea('message', null, array('class' => 'form-control input-lg', 'rows' => '5')) }}
				
				{{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg form-spacing-top')) }}
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection

@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
@endsection