@extends ('main')

@section ('title', 'Edit My Account')

@section ('content')
<div class="container">
	<div class="row">

		{!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}

		{{ csrf_field() }}
		
		<div class="col-md-4 col-md-offset-0">
			{{ Form::label('user_fname', 'First Name') }}
			{{ Form::text('user_fname', null, ['class' => 'form-control input-lg']) }}

			{{ Form::label('user_lname', 'Last Name') }}
			{{ Form::text('user_lname', null, ['class' => 'form-control input-lg']) }}

			{{ Form::label('user_tel', 'Phone Number') }}
			{{ Form::text('user_tel', null, ['class' => 'form-control input-lg']) }}

			{{ Form::label('user_gender', 'Gender') }}
			<select class="form-control input-lg form-spacing-top-8" name="user_gender">
				<option value="1">Male</option>
				<option value="2">Female</option>
			</select>
		</div>

		<div class="col-md-4 col-md-offset-0">
			{{ Form::label('user_address', 'Address') }}
			{{ Form::text('user_address', null, ['class' => 'form-control input-lg']) }}

			{{ Form::label('user_city', 'City') }}
			<select class="form-control input-lg form-spacing-top-8" name="user_city">
				@foreach ($cities as $city)
				<option value="{{ $city->city_name }}">{{ $city->city_name }}</option>
				@endforeach
			</select>

			{{ Form::label('user_state', 'State/Province') }}
			<select class="form-control input-lg form-spacing-top-8" name="user_state">
				@foreach ($states as $state)
				<option value="{{ $state->state_name }}">{{ $state->state_name }}</option>
				@endforeach
			</select>

			{{ Form::label('user_country', 'Country', array('class' => 'form-spacing-top-8')) }}
			<select class="form-control input-lg form-spacing-top-8" name="user_country">
					
				@foreach ($countries as $country)
				<option value="{{ $country->country_name }}">{{ $country->country_name }}</option>
				@endforeach

			</select>
		</div>

		<div class="col-md-4 col-md-offset-0">
			{{ Form::label('user_description', 'Describe your self') }}
			{{ Form::textarea('user_description', null, ['class' => 'form-control input-lg form-spacing-top']) }}
		</div>

		<div class="col-md-12 col-md-offset-0">
			<div class="col-sx-6 col-sm-6 col-md-2 col-md-offset-3">
				{!! Html::linkRoute('users.profile', 'Back to My Account', array($user->id), array('class' => 'btn btn-info btn-block btn-h1-spacing')) !!}
			</div>

			<div class="col-sx-6 col-sm-6 col-md-2 col-md-offset-2">
				{{ Form::submit('Update Account', ['class' => 'btn btn-success btn-block btn-h1-spacing']) }}
			</div>
		</div>

		{!! Form::close() !!}
	</div> <!-- end of header row-->
</div>
@endsection