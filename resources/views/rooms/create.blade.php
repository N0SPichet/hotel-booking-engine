@extends ('main')

@section ('title', 'Hosting')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<h2>Basic Information</h2>
			<hr>
		</div>
		<div class="col-md-6 col-md-offset-3">
			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
			{!! Form::open(array('route' => 'rooms.setscene', 'data-parsley-validate' => '')) !!}

					{{ Form::label('house_property', 'Is this listing a home, hotel, or something else?') }}
					<select class="form-control form-spacing-top-8" name="house_property">
						<option value="home">Home</option>
						<option value="hotel">Hotel</option>
						<option value="something">Something else</option>
					</select>

					{{ Form::label('housetypes_id', 'What type of property is this?') }}
					<select class="form-control form-spacing-top-8" name="housetypes_id">
						@foreach ($htypes as $htype)
						<option value="{{ $htype->id }}">{{ $htype->type_name }}</option>
						@endforeach
					</select>

					{{ Form::label('house_guestspace', 'What will guests have?') }}
					<select class="form-control form-spacing-top-8" name="house_guestspace">
						<option value="Entrie Place">Entrie place</option>
						<option value="Private room">Private room</option>
						<option value="Shared room">Shared room</option>
					</select>

					<hr>
					
					{{ Form::label('house_capacity', 'How many guests can your place accommodate?') }}
					{{ Form::number('house_capacity', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('house_bedrooms', 'How many bedrooms can guests use?') }}
					{{ Form::number('house_bedrooms', '1', array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('house_beds', 'How many beds can guests use?') }}
					{{ Form::number('house_beds', '1', array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('house_bathroom', 'How many bathrooms?') }}
					{{ Form::number('house_bathroom', '1', array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('house_bathroomprivate', 'Is the bathroom private?') }}
					<div class="form-check">
				    	<label class="form-check-label">
				        	<input type="radio" class="form-check-input" name="house_bathroomprivate" id="house_bathroomprivate" value="1">
				        	Yes
				      	</label>
				    </div>
				    <div class="form-check">
				    	<label class="form-check-label">
				        	<input type="radio" class="form-check-input" name="house_bathroomprivate" id="house_bathroomprivate" value="0">
				        	No
				      	</label>
				    </div>

				    <hr>


					{{ Form::label('addresscountries_id', 'Country', array('class' => 'form-spacing-top-8')) }}
					<select class="form-control form-spacing-top-8" name="addresscountries_id">
						@foreach ($countries as $country)
						<option value="{{ $country->id }}">{{ $country->country_name }}</option>
						@endforeach
					</select>
					
					{{ Form::label('house_address', 'Street Address') }}
					{{ Form::text('house_address', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('addresscities_id', 'City') }}
					<select class="form-control form-spacing-top-8" name="addresscities_id">
						@foreach ($cities as $city)
						<option value="{{ $city->id }}">{{ $city->city_name }}</option>
						@endforeach
					</select>

					{{ Form::label('addressstates_id', 'State/Province') }}
					<select class="form-control form-spacing-top-8" name="addressstates_id">
						@foreach ($states as $state)
						<option value="{{ $state->id }}">{{ $state->state_name }}</option>
						@endforeach
					</select>

					{{ Form::label('house_postcode', 'ZIP Code') }}
					{{ Form::text('house_postcode', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::submit('Next', array('class' => 'btn btn-success btn-lg form-spacing-top pull-right')) }}

			{!! Form::close() !!}
		</div>
	</div> 
</div>
@endsection