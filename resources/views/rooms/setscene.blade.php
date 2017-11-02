@extends ('main')

@section ('title', 'Hosting')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
	{!! Html::style('css/select2.min.css') !!}
@endsection

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<h2>Set the Scene</h2>
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
			
			<!-- <p>Is this listing a home, hotel, or something else? {{ $house_property  }} </p>
			<p>What type of property is this? {{ $housetypes_id }} </p>
			<p>What will guests have? {{ $house_guestspace }} </p>
        	<p>How many guests can your place accommodate? {{ $house_capacity }} </p>
        	<p>How many bedrooms can guests use? {{ $house_bedrooms }} </p>
        	<p>How many beds can guests use? {{ $house_beds }} </p>
        	<p>How many bathrooms? {{ $house_bathroom }} </p>
        	<p>Is the bathroom private? {{ $house_bathroomprivate }} </p>
        	<p>Country {{ $addresscountries_id }} </p>
        	<p>Street Address {{ $house_address }} </p>
        	<p>City{{ $addresscities_id }} </p>
        	<p>State/Province{{ $addressstates_id }} </p>
        	<p>ZIP Code {{ $house_postcode }} </p> -->

			{!! Form::open(array('route' => 'rooms.store', 'data-parsley-validate' => '','files' => true )) !!}
					{{ Form::label('house_title', 'House Title: ') }}
					{{ Form::text('house_title', null, array('class' => 'form-control', 'required' => '')) }}

					{{ Form::label('house_description', 'Short description of your house') }}
					{{ Form::textarea('house_description', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::label('image_names[]', 'Images') }}
					{{ Form::file('image_names[]', array('class' => 'form-control-file', 'multiple' => 'multiple')) }}

					{{ Form::label('houseitems', 'Amenities') }}
					<select class="form-control select2-multi form-spacing-top-8" name="houseitems[]" multiple="multiple">
						@foreach ($houseitems as $houseitem)
							<option value="{{ $houseitem->id }}">{{ $houseitem->houseitem_name }}</option>
							<!-- <input type="checkbox" name="houseitems[]" value="{{ $houseitem->id }}">{{ $houseitem->houseitem_name }} -->
						@endforeach
					</select>

					{{ Form::label('houserules', 'Rules') }}
					<select class="form-control select2-multi form-spacing-top-8" name="houserules[]" multiple="multiple">
						@foreach ($houserules as $houserule)
							<option value="{{ $houserule->id }}">{{ $houserule->houserule_name }}</option>
							<!-- <input type="checkbox" name="houseitems[]" value="{{ $houseitem->id }}">{{ $houseitem->houseitem_name }} -->
						@endforeach
					</select>

					{{ Form::label('house_price', 'Pricing', array('class' => 'form-spacing-top-8')) }}
					{{ Form::text('house_price', null, array('class' => 'form-control form-spacing-top-8', 'required' => '')) }}

					{{ Form::hidden('house_property', $house_property)}}
					{{ Form::hidden('housetypes_id', $housetypes_id)}}
					{{ Form::hidden('house_guestspace', $house_guestspace)}}
					{{ Form::hidden('house_capacity', $house_capacity)}}
					{{ Form::hidden('house_bedrooms', $house_bedrooms)}}
					{{ Form::hidden('house_beds', $house_beds)}}
					{{ Form::hidden('house_bathroom', $house_bathroom)}}
					{{ Form::hidden('house_bathroomprivate', $house_bathroomprivate)}}
					{{ Form::hidden('addresscountries_id', $addresscountries_id)}}
					{{ Form::hidden('house_address', $house_address)}}
					{{ Form::hidden('addresscities_id', $addresscities_id)}}
					{{ Form::hidden('addressstates_id', $addressstates_id)}}
					{{ Form::hidden('house_postcode', $house_postcode) }}

					{{ Form::submit('Save', array('class' => 'btn btn-success btn-lg form-spacing-top pull-right')) }}

			{!! Form::close() !!}
		</div>
	</div>
	<a href="{{ URL::previous() }}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-chevron-left "></span></a>
</div>
@endsection

@section('scripts')
	{!! Html::script('js/select2.min.js') !!}

	<script type="text/javascript">
		$('.select2-multi').select2();
	</script>
@endsection