@extends ('main')

@section ('title', 'Set Scene | Hosting')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
	{!! Html::style('css/select2.min.css') !!}
@endsection

@section ('content')
<div class="container">
	<div class="row">
			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
			{!! Form::open(array('route' => 'rooms.finalstep', 'data-parsley-validate' => '','files' => true )) !!}
				
				<div class="col-md-12 col-md-offset-0">
					<h2>Title</h2>
				</div>
				<div class="col-md-6 col-md-offset-3">
					{{ Form::label('house_title', 'House Title: ') }}
					{{ Form::text('house_title', null, array('class' => 'form-control', 'required' => '')) }}
				</div>

				<div class="col-md-12 col-md-offset-0">
					<hr>
					<h2>Photos</h2>
				</div>
				<div class="col-md-6 col-md-offset-3">
					{{ Form::label('image_names', 'Images', ['class' => 'form-spacing-top-8']) }}
					{{ Form::file('image_names[]', array('class' => 'form-control-file', 'multiple' => 'multiple')) }}
				</div>

				<div class="col-md-12 col-md-offset-0">
					<hr>
					<h2>Description</h2>
				</div>
				<div class="col-md-6 col-md-offset-3">
					{{ Form::label('house_description', 'Short description of your house', ['class' => 'form-spacing-top-8']) }}
					{{ Form::textarea('house_description', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}
						
					{{ Form::label('about_your_place', 'About your place (optional)', ['class' => 'form-spacing-top-8']) }}
					{{ Form::textarea('about_your_place', null, ['class' => 'form-control form-spacing-top-8']) }}

					{{ Form::label('guest_can_access', 'What guests can access (optional)', ['class' => 'form-spacing-top-8']) }}
					{{ Form::textarea('guest_can_access', null, ['class' => 'form-control form-spacing-top-8']) }}

					{{ Form::label('optional_note', 'Other things to note (optional)', ['class' => 'form-spacing-top-8']) }}
					{{ Form::textarea('optional_note', null, ['class' => 'form-control form-spacing-top-8']) }}
				</div>

				<div class="col-md-12 col-md-offset-0">
					<hr>
					<h2>The neighborhood</h2>
				</div>
				<div class="col-md-6 col-md-offset-3">
					{{ Form::label('about_neighborhood', 'About the neighborhood (optional)', ['class' => 'form-spacing-top-8']) }}
					{{ Form::textarea('about_neighborhood', null, ['class' => 'form-control form-spacing-top-8']) }}
				</div>
				
					{{ Form::hidden('id', $id)}}
				<div class="col-md-6 col-md-offset-3">
					{{ Form::submit('Next', array('class' => 'btn btn-success btn-lg form-spacing-top pull-right')) }}
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