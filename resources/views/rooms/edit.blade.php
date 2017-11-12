@extends ('main')

@section ('title', 'Edit Room')

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
		<div class="col-md-12 col-md-offset-0">
			<h2>Basic Information</h2>
			<hr>
		</div>
		<div class="col-md-6 col-md-offset-3">
			
			{!! Form::model($house, ['route' => ['rooms.update', $house->id], 'files' => true, 'method' => 'PUT']) !!}

					{{ Form::label('housetypes_id', 'What type of property is this?') }}
					{{ Form::select('housetypes_id', $types, null, ['class' => 'form-control']) }}

					<hr>
					
					{{ Form::label('house_capacity', 'How many guests can your place accommodate?') }}
					{{ Form::number('house_capacity', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('house_bedrooms', 'How many bedrooms can guests use?') }}
					{{ Form::number('house_bedrooms', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('house_beds', 'How many beds can guests use?') }}
					{{ Form::number('house_beds', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('house_bathroom', 'How many bathrooms?') }}
					{{ Form::number('house_bathroom', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

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
					{{ Form::select('addresscountries_id', $countries, null, ['class' => 'form-control form-spacing-top-8']) }}
					
					{{ Form::label('house_address', 'Street Address') }}
					{{ Form::text('house_address', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('addresscities_id', 'City') }}
					{{ Form::select('addresscities_id', $cities, null, ['class' => 'form-control form-spacing-top-8']) }}

					{{ Form::label('addressstates_id', 'State/Province') }}
					{{ Form::select('addressstates_id', $states, null, ['class' => 'form-control form-spacing-top-8']) }}

					{{ Form::label('house_postcode', 'ZIP Code') }}
					{{ Form::text('house_postcode', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}
			</div>
			<div class="col-md-12 col-md-offset-0">
				<h2>Set Scene</h2>
				<hr>
			</div>
			<div class="col-md-6 col-md-offset-3">
					{{ Form::label('house_title', 'House Title: ') }}
					{{ Form::text('house_title', null, array('class' => 'form-control', 'required' => '')) }}

					{{ Form::label('house_description', 'Short description of your house') }}
					{{ Form::textarea('house_description', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('image_name', 'Cover Images') }}
					{{ Form::select('image_name', $images, null, ['class' => 'form-control form-spacing-top-8']) }}

					{{ Form::label('image_names', 'Add new Images') }}
					{{ Form::file('image_names[]', array('class' => 'form-control-file', 'multiple' => 'multiple')) }}

					{{ Form::label('houseitems', 'Amenities') }}
					{{ Form::select('houseitems[]', $items, null, ['class' => 'form-control select2-multi form-spacing-top-8', 'multiple' => 'multiple']) }}

					{{ Form::label('houserules', 'Rules') }}
					{{ Form::select('houserules[]', $rules, null, ['class' => 'form-control select2-multi form-spacing-top-8', 'multiple' => 'multiple']) }}

					{{ Form::label('house_price', 'Pricing', array('class' => 'form-spacing-top-8')) }}
					{{ Form::text('house_price', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::submit('Next', array('class' => 'btn btn-success btn-lg form-spacing-top pull-right')) }}

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