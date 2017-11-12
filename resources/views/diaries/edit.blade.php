@extends ('main')

@section ('title', 'Edit Diary')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
	{!! Html::style('css/select2.min.css') !!}
@endsection

@section ('content')
<div class="container">
	<div class="row">

		{!! Form::model($diary, ['route' => ['diaries.update', $diary->id], 'method' => 'PUT']) !!}
			{{ csrf_field() }}
		<div class="col-md-8">
			{{ Form::label('title', 'Title:') }}
			{{ Form::text('title', null, ['class' => 'form-control']) }}

			{{ Form::label('categories_id', 'Category:') }}
			{{ Form::select('categories_id', $categories, null, ['class' => 'form-control']) }}

			{{ Form::label('tags', 'Tag: ') }}
			{{ Form::select('tags[]', $tags, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple']) }}

			{{ Form::label('message', 'Message:', ['class' => 'form-spacing-top']) }}
			{{ Form::textarea('message', null, ['class' => 'form-control']) }}
		</div>

		<div class="col-md-4 btn-h1-spacing">
			<div class="col-sm-6">
				{!! Html::linkRoute('diary.single', 'Cancel', array($diary->id), array('class' => 'btn btn-danger btn-block btn-h1-spacing')) !!}
			</div>

			<div class="col-sm-6">
				{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block btn-h1-spacing']) }}
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