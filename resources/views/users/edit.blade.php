@extends ('main')

@section ('title', 'Edit My Account')

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
	<div class="row">

		{!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}

		{{ csrf_field() }}
		
		<div class="col-md-6">
			{{ Form::label('user_fname', 'Name') }}
			{{ Form::text('user_fname', null, ['class' => 'form-control input-md']) }}

			{{ Form::label('user_lname', 'Last Name') }}
			{{ Form::text('user_lname', null, ['class' => 'form-control input-md']) }}

			{{ Form::label('user_tel', 'Phone Number') }}
			{{ Form::text('user_tel', null, ['class' => 'form-control input-md']) }}

			{{ Form::label('user_gender', 'Gender') }}
			<select class="form-control input-md margin-top-10" name="user_gender">
				<option {{ $user->user_gender===null ? 'selected':'' }}>Select Gender</option>
				<option value="1" {{ $user->user_gender==='1' ? 'selected'  : '' }}>Male</option>
				<option value="2" {{ $user->user_gender==='2' ? 'selected'  : '' }}>Female</option>
			</select>
		</div>

		<div class="col-md-6">
			{{ Form::label('user_address', 'Address') }}
			{{ Form::text('user_address', null, ['class' => 'form-control input-md']) }}

			{{ Form::label('user_city', 'City') }}
			<select class="form-control input-md margin-top-10" name="user_city">
				<option value="0">Select City</option>
				@foreach ($cities as $city)
				<option value="{{ $city->city_name }}">{{ $city->city_name }}</option>
				@endforeach
			</select>

			{{ Form::label('user_state', 'State/Province') }}
			<select class="form-control input-md margin-top-10" name="user_state">
				<option value="0">Select State</option>
				@foreach ($states as $state)
				<option value="{{ $state->state_name }}">{{ $state->state_name }}</option>
				@endforeach
			</select>

			{{ Form::label('user_country', 'Country', array('class' => 'margin-top-10')) }}
			<select class="form-control input-md margin-top-10" name="user_country">
				<option value="0">Select Country</option>
				@foreach ($countries as $country)
				@if ($country->country_name == 'Thailand')
				<option value="{{ $country->country_name }}">{{ $country->country_name }}</option>
				@endif
				@endforeach

			</select>
		</div>

		<div class="col-md-8 col-md-offset-2">
			{{ Form::label('user_description', 'Describe your self', array('class' => 'margin-top-10')) }}
			{{ Form::textarea('user_description', null, ['class' => 'form-control input-md form-spacing-top']) }}

			<div class="col-sm-6 col-md-6">
				{!! Html::linkRoute('users.profile', 'Back to My Account', array($user->id), array('class' => 'btn btn-info btn-block btn-h1-spacing')) !!}
			</div>

			<div class="col-sm-6 col-md-6">
				{{ Form::submit('Update', ['class' => 'btn btn-success btn-block btn-h1-spacing']) }}
			</div>
		</div>

		{!! Form::close() !!}
	</div> <!-- end of header row-->
</div>
@endsection