@extends ('main')

@section ('title', 'My Diary')

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
				
				{{ Form::label('message', 'Message: ') }}
				{{ Form::textarea('message', null, array('class' => 'form-control input-lg', 'required' => '')) }}
				
				{{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg form-spacing-top')) }}
			{!! Form::close() !!}
		</div>
	</div> <!-- end of header row-->
</div>
@endsection