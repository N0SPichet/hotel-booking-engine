@extends ('dashboard.main')
@section ('title', 'Edit Room')
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
<div class="container rooms">
	<div class="row m-t-10">
		@if ($errors->any())
		<div class="alert alert-danger">
		    <ul>
		        @foreach ($errors->all() as $error)
		        <li>{{ $error }}</li>
		        @endforeach
		    </ul>
		</div>
		@endif
		<div class="col-md-2 float-left create">
			<ul class="nav flex-column">
				<li class="nav-item">
					<a class="active" data-toggle="tab" href="#menu1">Basic info</a>
				</li>
				<li class="nav-item">
					<a data-toggle="tab" href="#menu2">Address</a>
				</li>
				<li class="nav-item">
					<a data-toggle="tab" href="#menu3">Amenities and Space</a>
				</li>
				<li class="nav-item">
					<a data-toggle="tab" href="#menu4">Title and Description</a>
				</li>
				<li class="nav-item">
					<a data-toggle="tab" href="#menu5">Images</a>
				</li>
				<li class="nav-item">
					<a data-toggle="tab" href="#menu6">Rules</a>
				</li>
				<li class="nav-item">
					<a data-toggle="tab" href="#menu7">Pricing</a>
				</li>
			</ul>
		</div>

		<div class="col-md-8 float-left">
			<div class="tab-content">
		    	<div id="menu1" class="tab-pane fade show active in">
		    		<div class="col-md-10 float-left m-t-10">
		    			{!! Form::model($house, ['route' => ['rooms.update', $house->id], 'data-parsley-validate' => '', 'files' => true, 'method' => 'PUT']) !!}

						{{ Form::label('housetype_id', 'What type of property is this?') }}
						<select id="housetype_id" class="form-control m-t-10" name="housetype_id">
							<option value="0" disabled="">Select Type</option>
							@foreach ($types as $type)
							@if($house->housetype_id !== null)
							<option value="{{ $type->id }}" {{ $type->id==$house->housetype_id? 'selected':'' }}>{{ $type->name }}</option>
							@else
							<option value="{{ $type->id }}" {{ $type->id==1? 'selected':'' }}>{{ $type->name }}</option>
							@endif
							@endforeach
						</select>
						<hr>
						{{ Form::label('house_guestspace', '* What will guests have?', ['class' => 'm-t-10']) }}
						<select class="form-control m-t-10" name="house_guestspace">
							<option value="Entrie" {{ $house->house_guestspace == 'Entrie' ? 'selected':'' }}>Entrie place</option>
							<option value="Private" {{ $house->house_guestspace == 'Private' ? 'selected':'' }}>Private room</option>
							<option value="Shared" {{ $house->house_guestspace == 'Shared' ? 'selected':'' }}>Shared room</option>
						</select>

						{{ Form::label('house_capacity', 'How many guests can your place accommodate?') }}
						{{ Form::number('house_capacity', null, array('class' => 'form-control m-t-10', 'required' => '')) }}

						{{ Form::label('house_bedrooms', 'How many bedrooms can guests use?') }}
						{{ Form::number('house_bedrooms', null, array('class' => 'form-control m-t-10', 'required' => '')) }}

						{{ Form::label('house_beds', 'How many beds can guests use?') }}
						{{ Form::number('house_beds', null, array('class' => 'form-control m-t-10', 'required' => '')) }}

						{{ Form::label('house_bathroom', 'How many bathrooms?') }}
						{{ Form::number('house_bathroom', null, array('class' => 'form-control m-t-10', 'required' => '')) }}

						<p>{{ Form::label('house_bathroomprivate', 'Is the bathroom private?') }}</p>
						<div class="col-md-6 float-left" align="center">
							<div class="form-check form-check-inline">
				  				<input class="form-check-input" type="radio" id="bathroomprivateyes" name="house_bathroomprivate" value="1" {{ $house->house_bathroomprivate=='1' ? 'checked'  : '' }}>
				  				<label class="form-check-label" for="bathroomprivateyes">Yes</label>
							</div>
						</div>
						<div class="col-md-6 float-left" align="center">
							<div class="form-check form-check-inline">
				 				<input class="form-check-input" type="radio" id="bathroomprivateno" name="house_bathroomprivate" value="0" {{ $house->house_bathroomprivate=='0' ? 'checked'  : '' }}>
				  				<label class="form-check-label" for="bathroomprivateno">No</label>
							</div>
						</div>
		    		</div>
		    	</div>

		    	<div id="menu2" class="tab-pane fade show">
		    		<div class="col-md-10 float-left m-t-10">
		    			{{ Form::label('province_id', 'Provinces', array('class' => 'm-t-10')) }}
						<select id="province_id" class="form-control m-t-10" name="province_id">
							<option value="0">Select Provinces</option>
							@foreach ($provinces as $province)
							@if($house->province_id !== null)
							<option value="{{ $province->id }}" {{ $province->id===$house->province_id? 'selected':'' }}>{{ $province->name }}</option>
							@else
							<option value="{{ $province->id }}" {{ $province->id===1? 'selected':'' }}>{{ $province->name }}</option>
							@endif
							@endforeach
						</select>

						{{ Form::label('district_id', 'Districts') }}
						<select id="district_id" class="form-control m-t-10" name="district_id">
							<option value="0">Select Districts</option>
							@foreach ($districts as $district)
							@if($house->district_id !== null)
							<option value="{{ $district->id }}" {{ $district->id===$house->district_id? 'selected':'' }}>{{ $district->name }}</option>
							@else
							<option value="{{ $district->id }}" {{ $district->id===1? 'selected':'' }}>{{ $district->name }}</option>
							@endif
							@endforeach
						</select>

						{{ Form::label('sub_district_id', 'Sub Districts') }}
						<select id="sub_district_id" class="form-control m-t-10" name="sub_district_id">
							<option value="0">Select Sub Districts</option>
							@foreach ($sub_districts as $sub_district)
							@if($house->sub_district_id !== null)
							<option value="{{ $sub_district->id }}" {{ $sub_district->id===$house->sub_district_id? 'selected':'' }}>{{ $sub_district->name }}</option>
							@else
							<option value="{{ $sub_district->id }}" {{ $sub_district->id===1? 'selected':'' }}>{{ $sub_district->name }}</option>
							@endif
							@endforeach
						</select>

						{{ Form::label('house_postcode', 'ZIP Code') }}
						{{ Form::text('house_postcode', null, array('class' => 'form-control m-t-10', 'required' => '')) }}

						{{ Form::label('house_address', 'Street Address') }}
						{{ Form::text('house_address', null, array('class' => 'form-control m-t-10', 'required' => '')) }}
		    		</div>
		    	</div>

		    	<div id="menu3" class="tab-pane fade show">
		    		<div class="col-md-10 float-left m-t-10">
		    			{{ Form::label('houseamenities', 'What amenities do you offer?', ['class' => 'm-t-10']) }}
		    			<div class="row ">
							@foreach ($amenities as $amenity)
							<div class="col-md-6" >
								{{ Form::checkbox('houseamenities[]', $amenity->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "amenity$amenity->id"]) }}
								{{ Form::label('amenity' . $amenity->id, $amenity->amenityname) }}
							</div>
							@endforeach
						</div>

						{{ Form::label('housespaces', 'What spaces can guests use?', ['class' => 'm-t-10']) }}
						<div class="row">
							@foreach ($spaces as $space)
							<div class="col-md-6 float-left">
								{{ Form::checkbox('housespaces[]', $space->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "space$space->id"]) }}
								{{ Form::label('space' . $space->id, $space->spacename) }}
							</div>
							@endforeach
						</div>
		    		</div>
		    	</div>

		    	<div id="menu4" class="tab-pane fade show">
		    		<div class="col-md-10 float-left m-t-10">
		    			{{ Form::label('house_title', 'House Title: ') }}
						{{ Form::text('house_title', null, ['class' => 'form-control', 'required' => '', "data-parsley-trigger"=>"keyup", "data-parsley-minlength"=>"8", "data-parsley-maxlength"=>"100", "data-parsley-minlength-message"=>"Title should be 8 characters long."]) }}

						{{ Form::label('house_description', 'Short description of your house') }}
						{{ Form::textarea('house_description', null, ['class' => 'form-control m-t-10', 'required' => '', 'rows' => '5']) }}

						{{ Form::label('about_your_place', 'About your place (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('about_your_place', null, ['class' => 'form-control m-t-10', 'rows' => '5']) }}

						{{ Form::label('guest_can_access', 'What guests can access (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('guest_can_access', null, ['class' => 'form-control m-t-10', 'rows' => '5']) }}

						{{ Form::label('optional_note', 'Other things to note (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('optional_note', null, ['class' => 'form-control m-t-10', 'rows' => '5']) }}

						{{ Form::label('about_neighborhood', 'About the neighborhood (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('about_neighborhood', null, ['class' => 'form-control m-t-10', 'rows' => '5']) }}
		    		</div>
		    	</div>

		    	<div id="menu5" class="tab-pane fade show">
		    		<div class="col-md-10 float-left m-t-10">
		    			{{ Form::label('cover_image', 'Cover Images') }}
						<div class="row">
							@foreach ($houseimages as $index => $image)
							<div class="col-md-4 margin-content">
								<div class="form-check">
				  				<input class="form-check-input" type="radio" name="cover_image" id="{{ $index }}" value="{{ $image->name }}" {{ $image->name == $house->cover_image ? 'checked'  : '' }}>
					  			<label class="form-check-label" for="{{ $index }}">
					  				@if($house->cover_image == $image->name)
					  				<span class="use_as_home_thum">Home</span>
					  				@endif
					    			<img src="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}" class="img-responsive">
					  			</label>
								</div>
							</div>
							@endforeach
						</div>

						{{ Form::label('image_names', 'New Images') }}
						{{ Form::file('image_names[]', ['class' => 'form-control-file', 'multiple' => 'multiple']) }}
		    		</div>
		    	</div>

		    	<div id="menu6" class="tab-pane fade show">
		    		<div class="col-md-10 float-left m-t-10">
		    			{{ Form::label('houserules', 'Rules') }}
						<div class="row">
							@foreach ($rules as $rule)
							<div class="col-md-6 float-left">
								{{ Form::checkbox('houserules[]', $rule->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "rules$rule->id"]) }}
								{{ Form::label('rules' . $rule->id, $rule->name) }}
							</div>
							@endforeach
						</div>

						{{ Form::label('optional_rules', 'Rules (Optional)', ['class' => 'm-t-10']) }}
						{{ Form::text('optional_rules', null, ['class' => 'form-control m-t-10']) }}

						{{ Form::label('housedetails', 'Details guests must know about your home', ['class' => 'm-t-10']) }}
						<div class="row">
							@foreach ($details as $detail)
							<div class="col-md-6 float-left">
								{{ Form::checkbox('housedetails[]', $detail->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "details$detail->id"]) }}
								{{ Form::label('details' . $detail->id, $detail->name) }}
							</div>
							@endforeach
						</div>
		    		</div>
		    	</div>

		    	<div id="menu7" class="tab-pane fade show">
		    		<div class="col-md-10 float-left m-t-10">
		    			{{ Form::label('notice', 'How much notice do you need before a guest arrives?') }}
						<select class="form-control m-t-10" name="notice">
							<option value="Same Day" {{ $house->guestarrives->notice=='Same Day' ? 'selected' : '' }}>Same Day</option>
							<option value="1 Day" {{ $house->guestarrives->notice=='1 Day' ? 'selected' : '' }}>1 Day</option>
							<option value="2 Days" {{ $house->guestarrives->notice=='2 Days' ? 'selected' : '' }}>2 Days</option>
							<option value="3 Days" {{ $house->guestarrives->notice=='3 Days' ? 'selected' : '' }}>3 Days</option>
							<option value="7 Days" {{ $house->guestarrives->notice=='7 Days' ? 'selected' : '' }}>7 Days</option>
						</select>

		    			<p class="m-t-10"><b>This price for per person or for a day?</b></p>
						<div class="form-check form-check-inline">
		  					<input class="form-check-input" type="radio" id="inlineprice_perperson1" name="price_perperson" value="1" {{ $house->houseprices->price_perperson=='1' ? 'checked'  : '' }}>
		  					<label class="form-check-label" for="inlineprice_perperson1">Per Person</label>
						</div>
						<div class="form-check form-check-inline">
		 					<input class="form-check-input" type="radio" id="inlineprice_perperson2" name="price_perperson" value="2" {{ $house->houseprices->price_perperson=='2' ? 'checked'  : '' }}>
		  					<label class="form-check-label" for="inlineprice_perperson2">Per Day</label>
						</div>
						<br>

						{{ Form::label('price', 'Room price (THB)', ['style' => 'm-t: 20px;']) }}
						{{ Form::text('price', $house->houseprices->price, ['class' => 'form-control m-t-10']) }}

						{{ Form::label('food_price', 'Food price (THB) (optional)') }}
						{{ Form::text('food_price', $house->houseprices->food_price, ['class' => 'form-control m-t-10']) }}

						<div class="row">
							<div class="col-md-4 float-left">
								<div class="form-check form-check-inline">
				  					<input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="food_breakfast" value="1" {{ $house->foods->breakfast == '1' ? 'checked' : '' }}>
				  					<label class="form-check-label" for="inlineCheckbox1">Breakfast</label>
								</div>
							</div>
							<div class="col-md-4 float-left">
								<div class="form-check form-check-inline">
				 					<input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="food_lunch" value="1" {{ $house->foods->lunch == '1' ? 'checked' : '' }}>
				  					<label class="form-check-label" for="inlineCheckbox2">Lunch</label>
								</div>
							</div>
							<div class="col-md-4 float-left">
								<div class="form-check form-check-inline">
				 					<input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="food_dinner" value="1" {{ $house->foods->dinner == '1' ? 'checked' : '' }}>
				  					<label class="form-check-label" for="inlineCheckbox3">Dinner</label>
								</div>
							</div>
						</div>

						<div class="form-check" style="margin-top: 20px;">
		  					<input class="form-check-input" type="radio" name="welcome_offer" id="welcome_offer" value="1" {{ $house->houseprices->welcome_offer=='1' ? 'checked'  : '' }}>
		  					<label class="form-check-label" for="welcome_offer" style="margin-left: 20px;">
		    					Offer 15% off to your first guest
		  					</label>
						</div>
						<div class="form-check">
		  					<input class="form-check-input" type="radio" name="welcome_offer" id="welcome_offer" value="0" {{ $house->houseprices->welcome_offer=='0' ? 'checked'  : '' }}>
		  					<label class="form-check-label" for="welcome_offer" style="margin-left: 20px;">
		    					No
		  					</label>
						</div>

						{{ Form::label('weekly_discount', 'Weekly discount (%)', ['style' => 'm-t: 20px;']) }}
						{{ Form::text('weekly_discount', $house->houseprices->weekly_discount, ['class' => 'form-control m-t-10']) }}

						{{ Form::label('monthly_discount', 'Monthly discount (%)') }}
						{{ Form::text('monthly_discount', $house->houseprices->monthly_discount, ['class' => 'form-control m-t-10']) }}
		    		</div>
		    	</div>
		    </div>
		</div>
		<div class="col-md-2 float-left">
			{{ Form::submit('Save Change', array('class' => 'btn btn-warning m-t-10 pull-right')) }}
			{!! Form::close() !!}
			<a class="btn btn-outline-secondary m-t-10 pull-right" href="{{ route('rooms.owner', $house->id) }}">Back</a>
		</div>
	</div> 
</div>
@endsection

@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
<script type="text/javascript">
	$(document).ready(function() {
		$('#province_id').on('change', function() {
			var p_id = $(this).val();
			var url = "{{ route('api.get.province', ":id") }}";
			url = url.replace(':id', p_id);
			$.ajax({
				type: "get",
				url: url,
				data: {},
				success: function (response) {
					$('#postal_code').val('');
					$('#district_id').empty();
					$('#district_id').append('<option value="0">Select Districts</option>');
					$('#sub_district_id').empty();
					$('#sub_district_id').append('<option value="0">Select Sub Districts</option>');
					$.each(response.data, function(index, data) {
						$('#district_id').append('<option value="'+data.id+'">'+data.name+'</option>');
					});
				}
			});
		});
	
		$('#district_id').on('change', function() {
			var d_id = $(this).val();
			var url = "{{ route('api.get.district', ":id") }}";
			url = url.replace(':id', d_id);
			$.ajax({
				type: "get",
				url: url,
				data: {},
				success: function (response) {
					$('#postal_code').val('');
					$('#sub_district_id').empty();
					$('#sub_district_id').append('<option value="0">Select Sub Districts</option>');
					$.each(response.data, function(index, data) {
						$('#sub_district_id').append('<option value="'+data.id+'">'+data.name+'</option>');
					});
				}
			});
		});
	
		$('#sub_district_id').on('change', function() {
			var post_id = $(this).val();
			var url = "{{ route('api.get.postalcode', ":id") }}";
			url = url.replace(':id', post_id);
			$.ajax({
				type: "get",
				url: url,
				data: {},
				success: function (response) {
					$('#postal_code').val(response.data.code);
				}
			});
		});
	
		$('#postal_code').on('change', function(event) {
			event.preventDefault();
			var post_id = $(this).val();
			var url = "{{ route('api.search.postalcode', ":id") }}";
			url = url.replace(':id', post_id);
			$.ajax({
				type: "get",
				url: url,
				data: {},
				success: function (response) {
					console.log(response.data);
					/*
					$('#province_id').empty();
					$('#province_id').append('<option value="0">Select Provinces</option>');
					*/
				}
			});
		});
	});
</script>
@endsection
