@extends ('main')

@section ('title', 'My Diary')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
	{!! Html::style('css/select2.min.css') !!}
@endsection

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2>{{ Auth::user()->user_fname }} Diary</h2>
			<hr>
			{!! Form::open(array('route' => 'diaries.store', 'data-parsley-validate' => '')) !!}
			
				{{ Form::label('title', 'Title: ') }}
				{{ Form::text('title', null, array('class' => 'form-control input-lg', 'required' => '')) }}

				{{ Form::label('category_name', 'Category:') }}
				<select class="form-control input-lg" name="categories_id">
					
					@foreach ($categories as $category)
					<option value="{{ $category->id }}">{{ $category->category_name }}</option>
					@endforeach

				</select>

				{{ Form::label('tags', 'Tag: ') }}
				<select class="form-control select2-multi form-spacing-top-8" name="tags[]" multiple="multiple">
					@foreach ($tags as $tag)
						<option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
					@endforeach
				</select>
				
				{{ Form::label('message', 'Message: ') }}
				{{ Form::textarea('message', null, array('class' => 'form-control input-lg', 'required' => '')) }}
				
				{{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg form-spacing-top')) }}
			{!! Form::close() !!}
		</div>
	</div> <!-- end of header row-->
</div>
@endsection

@section('scripts')
	{!! Html::script('js/select2.min.js') !!}

	<script type="text/javascript">
		$('.select2-multi').select2();
	</script>
@endsection