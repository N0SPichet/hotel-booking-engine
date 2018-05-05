@extends ('main')

@section ('title', 'Edit Trip Diary '. ($day != '0' ? 'Day '.$day: ''))

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
		<div class="col">
			{!! Form::model($diary, ['route' => ['tripdiary_update', $diary->id ], 'method' => 'PUT', 'files' => true]) !!}
			<div class="col-md-9">
				@if ($day != 0)
				<h4>{{ $diary_title }} day {{ $day }}</h4>
				@elseif ($day == 0)
				{{ Form::label('title', 'Title:') }}
				{{ Form::text('title', null, ['class' => 'form-control']) }}

				{{ Form::label('categories_id', 'Category:', ['class' => 'form-spacing-top']) }}
				{{ Form::select('categories_id', $categories, null, ['class' => 'form-control']) }}

				{{ Form::label('tags', 'Tag: ', ['class' => 'form-spacing-top']) }}
				{{ Form::select('tags[]', $tags, null, ['class' => 'form-control select2-multi form-spacing-top-8', 'multiple' => 'multiple']) }}

				{{ Form::label('cover_image', 'Cover image: ', ['class' => 'form-spacing-top']) }}
				{{ Form::file('cover_image', null, ['class' => 'form-control select2-multi form-spacing-top-8']) }}
				@endif
				@if ($day != 0)
				{{ Form::label('images', 'Image: ', ['class' => 'form-spacing-top']) }}
				{{ Form::file('images[]', ['class' => 'form-control-file', 'multiple' => 'multiple']) }}
				@endif
				{{ Form::label('message', 'Body:', ['class' => 'form-spacing-top']) }}
				{{ Form::textarea('message', null, ['class' => 'form-control', 'rows' => '5']) }}
				@if ($day == 0)
				{{ Form::label('publish', 'Who see this diary?', ['class' => 'margin-top-10']) }}
				<select name="publish" class="form-control margin-top-10" style="width: 20%;">
					<option value="2" {{ $diary->publish == '2' ? 'selected' : '' }}>Public</option>
					<option value="1" {{ $diary->publish == '1' ? 'selected' : '' }}>Follower</option>
					<option value="0" {{ $diary->publish == '0' ? 'selected' : '' }}>Private</option>
				</select>
				@endif
			</div>
			<div class="col-md-3 btn-h1-spacing">
				<div class="col-sm-6">
				{!! Html::linkRoute('tripdiary', 'Cancel', array($diary->rentals->id), array('class' => 'btn btn-danger btn-block btn-h1-spacing')) !!}
				</div>

				<div class="col-sm-6">
				{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-h1-spacing']) }}
				</div>
			</div>
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