@extends ('dashboard.main')
@section ('title', 'Edit Apartment')
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
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
						{!! Form::model($house, ['route' => ['apartments.update', $house->id], 'data-parsley-validate' => '', 'files' => true, 'method' => 'PUT']) !!}
						<h2>Basic</h2>
						{{ Form::label('housetype_id', '* What type of property is this?', ['class' => 'm-t-10']) }}
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

						{{ Form::label('type_single', 'Single Room (Standard)', ['class' => 'm-t-10']) }}
						<select id="type_single" name="type_single" class="form-control">
							@for ($i = 0; $i <= 20; $i++)
							<option value="{{ $i }}" {{ $house->apartmentprices->type_single == $i ? 'selected':'' }}>{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('type_deluxe_single', 'Deluxe Single Room', ['class' => 'm-t-10']) }}
						<select id="type_deluxe_single" name="type_deluxe_single" class="form-control">
							@for ($i = 0; $i <= 20; $i++)
							<option value="{{ $i }}" {{ $house->apartmentprices->type_deluxe_single == $i ? 'selected':'' }}>{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('type_double_room', 'Double Room (Standard)', ['class' => 'm-t-10']) }}
						<select id="type_double_room" name="type_double_room" class="form-control">
							@for ($i = 0; $i <= 20; $i++)
							<option value="{{ $i }}" {{ $house->apartmentprices->type_double_room == $i ? 'selected':'' }}>{{ $i }}</option>
							@endfor
						</select>
						
						{{ Form::label('house_guestspace', '* What will guests have?', ['class' => 'm-t-10']) }}
						<select class="form-control m-t-10" name="house_guestspace">
							<option value="Entrie" {{ $house->house_guestspace == 'Entrie' ? 'selected':'' }}>Entrie place</option>
							<option value="Private" {{ $house->house_guestspace == 'Private' ? 'selected':'' }}>Private room</option>
							<option value="Shared" {{ $house->house_guestspace == 'Shared' ? 'selected':'' }}>Shared room</option>
						</select>

						{{ Form::label('house_capacity', '* How many guests can your place accommodate each room?', ['class' => 'm-t-10']) }}
						<select id="house_capacity" name="house_capacity" class="form-control" required="">
							@for ($i = 1; $i<=8; $i++)
							<option value="{{ $i }}" {{ $house->house_capacity==$i ? 'selected':'' }}>{{ $i }}</option>
							@endfor
						</select>

						<h2>Rooms</h2>
						{{ Form::label('house_bedrooms', '* How many bedrooms in each room?', ['class' => 'm-t-10']) }}
						<select id="house_bedrooms" name="house_bedrooms" class="form-control" required="">
							@for ($i = 1; $i <= 4; $i++)
							<option value="{{ $i }}" {{ $house->house_bedrooms==$i ? 'selected':'' }}>{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('house_beds', '* How many beds in each room?', ['class' => 'm-t-10']) }}
						<select id="house_beds" name="house_beds" class="form-control" required="">
							@for ($i = 1; $i <= 4; $i++)
							<option value="{{ $i }}" {{ $house->house_beds==$i ? 'selected':'' }}>{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('house_bathroom', '* How many bathrooms in each room?', ['class' => 'm-t-10']) }}
						<select id="house_bathroom" name="house_bathroom" class="form-control" required="">
							@for ($i = 1; $i <= 4; $i++)
							<option value="{{ $i }}" {{ $house->house_bathroom==$i ? 'selected':'' }}>{{ $i }}</option>
							@endfor
						</select>

						<p>{{ Form::label('house_bathroomprivate', '* Is the bathroom private?', ['class' => 'm-t-10']) }}</p>
						<div class="col-md-3 float-left" align="center">
							<div class="form-check form-check-inline">
				  				<input class="form-check-input" type="radio" id="bathroomprivateyes" name="house_bathroomprivate" value="1" {{ $house->house_bathroomprivate=='1' ? 'checked'  : '' }}>
				  				<label class="form-check-label" for="bathroomprivateyes">Yes</label>
							</div>
						</div>
						<div class="col-md-3 float-left" align="center">
							<div class="form-check form-check-inline">
				 				<input class="form-check-input" type="radio" id="bathroomprivateno" name="house_bathroomprivate" value="0" {{ $house->house_bathroomprivate=='0' ? 'checked'  : '' }}>
				  				<label class="form-check-label" for="bathroomprivateno">No</label>
							</div>
						</div>
					</div>
				</div>
				<div id="menu2" class="tab-pane fade show">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Address and Map</h2>
						{{ Form::label('province_id', 'Provinces', ['class' => 'm-t-10']) }}
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
								
						{{ Form::label('district_id', 'Districts', ['class' => 'm-t-10']) }}
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

						{{ Form::label('sub_district_id', 'Sub Districts', ['class' => 'm-t-10']) }}
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

						{{ Form::label('house_postcode', '* ZIP Code', ['class' => 'm-t-10']) }}
						{{ Form::text('house_postcode', null, array('class' => 'form-control m-t-10', 'required' => '')) }}

						{{ Form::label('house_address', '* Street Address', ['class' => 'm-t-10']) }}
						{{ Form::text('house_address', null, array('class' => 'form-control m-t-10', 'required' => '')) }}
					</div>
		    	</div>
		    	<div id="menu3" class="tab-pane fade show">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Amenities</h2>
						{{ Form::label('houseamenities', '* What amenities do you offer?', ['class' => 'm-t-10']) }}
						<div class="row ">
							@foreach ($amenities as $amenity)
							<div class="col-md-6" >
								{{ Form::checkbox('houseamenities[]', $amenity->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "amenity$amenity->id"]) }}
								{{ Form::label('amenity' . $amenity->id, $amenity->amenityname) }}
							</div>
							@endforeach
						</div>

						<h2>Space</h2>
						{{ Form::label('housespaces', '* What spaces can guests use?', ['class' => 'm-t-10']) }}
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
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Title</h2>
						{{ Form::label('house_title', '* House Title: ', ['class' => 'm-t-10']) }}
						{{ Form::text('house_title', null, ['class' => 'form-control', 'required' => '', "data-parsley-trigger"=>"keyup", "data-parsley-minlength"=>"8", "data-parsley-maxlength"=>"100", "data-parsley-minlength-message"=>"Title should be 8 characters long."]) }}

						<h2>Description</h2>
						{{ Form::label('house_description', '* Short description of your house', ['class' => 'm-t-10']) }}
						{{ Form::textarea('house_description', null, ['class' => 'form-control m-t-10', 'required' => '']) }}

						{{ Form::label('about_your_place', 'About your place (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('about_your_place', null, ['class' => 'form-control m-t-10']) }}

						{{ Form::label('guest_can_access', 'What guests can access (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('guest_can_access', null, ['class' => 'form-control m-t-10']) }}

						{{ Form::label('optional_note', 'Other things to note (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('optional_note', null, ['class' => 'form-control m-t-10']) }}

						<h2>The neighborhood</h2>
						{{ Form::label('about_neighborhood', 'About the neighborhood (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('about_neighborhood', null, ['class' => 'form-control m-t-10']) }}
					</div>
		    	</div>
		    	<div id="menu5" class="tab-pane fade show">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			{{ Form::label('image_name', '* Cover Images', ['class' => 'm-t-10']) }}
						<div class="row">
							@foreach ($houseimages as $index => $image)
							<div class="col-md-4 margin-content">
								<div class="form-check">
				  				<input class="form-check-input" type="radio" name="image_name" id="{{ $index }}" value="{{ $image->name }}" {{ $image->name == $house->cover_image ? 'checked'  : '' }}>
					  			<label class="form-check-label" for="{{ $index }}">
					  				@if($house->cover_image == $image->name)
					  				<span class="use_as_home_thum">Home</span>
					  				@endif
					    			<img src="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}" class="img-responsive" style="width: 100%;">
					  			</label>
								</div>
							</div>
							@endforeach
						</div>

						<h2>Photos</h2>
						{{ Form::label('image_names', 'Add new Images', ['class' => 'm-t-10']) }}
						{{ Form::file('image_names[]', ['class' => 'form-control-file', 'multiple' => 'multiple']) }}

						<div id="hidden_type_single" style="display: none;">
						{{ Form::label('type_single_images', '* Single Room (Standard)', ['class' => 'm-t-10']) }}
						{{ Form::file('type_single_images[]', array('class' => 'form-control-file', 'multiple' => 'multiple')) }}
						</div>

						<div id="hidden_type_deluxe_single" style="display: none;">
						{{ Form::label('type_deluxe_single_images', '* Deluxe Single Room', ['class' => 'm-t-10']) }}
						{{ Form::file('type_deluxe_single_images[]', array('class' => 'form-control-file', 'multiple' => 'multiple')) }}
						</div>

						<div id="hidden_type_double_room" style="display: none;">
						{{ Form::label('type_double_room_images', '* Double Room (Standard)', ['class' => 'm-t-10']) }}
						{{ Form::file('type_double_room_images[]', array('class' => 'form-control-file', 'multiple' => 'multiple')) }}
						</div>
		    		</div>
		    	</div>
		    	<div id="menu6" class="tab-pane fade show">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Rules</h2>
	    				{{ Form::label('houserules', '* Rules', ['class' => 'm-t-10']) }}
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
						
		    			{{ Form::label('housedetails', '* Details guests must know about your home', ['class' => 'm-t-10']) }}
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
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Availability</h2>
		    			{{ Form::label('notice', '* How much notice do you need before a guest arrives?', ['class' => 'm-t-10']) }}
						<select class="form-control m-t-10" name="notice">
							<option value="Same Day" {{ $house->guestarrives->notice=='Same Day' ? 'selected' : '' }}>Same Day</option>
							<option value="1 Day" {{ $house->guestarrives->notice=='1 Day' ? 'selected' : '' }}>1 Day</option>
							<option value="2 Days" {{ $house->guestarrives->notice=='2 Days' ? 'selected' : '' }}>2 Days</option>
							<option value="3 Days" {{ $house->guestarrives->notice=='3 Days' ? 'selected' : '' }}>3 Days</option>
							<option value="7 Days" {{ $house->guestarrives->notice=='7 Days' ? 'selected' : '' }}>7 Days</option>
						</select>

		    			<p class="m-t-10"><b>* When can guests check in?</b></p>
						<div class="col-md-6">
							{{ Form::label('checkin_from', 'From:') }}
							<select class="form-control m-t-10" name="checkin_from">
								<option value="Flexible" {{ $house->guestarrives->checkin_from=='Flexible' ? 'selected':'' }}>Flexible</option>
								<option value="8AM" {{ $house->guestarrives->checkin_from=='8AM' ? 'selected':'' }}>8AM</option>
								<option value="9AM" {{ $house->guestarrives->checkin_from=='9AM' ? 'selected':'' }}>9AM</option>
								<option value="10AM" {{ $house->guestarrives->checkin_from=='10AM' ? 'selected':'' }}>10AM</option>
								<option value="11AM" {{ $house->guestarrives->checkin_from=='11AM' ? 'selected':'' }}>11AM</option>
								<option value="12PM (noon)" {{ $house->guestarrives->checkin_from=='12PM (noon)' ? 'selected':'' }}>12PM (noon)</option>
								<option value="1PM" {{ $house->guestarrives->checkin_from=='1PM' ? 'selected':'' }}>1PM</option>
								<option value="2PM" {{ $house->guestarrives->checkin_from=='2PM' ? 'selected':'' }}>2PM</option>
								<option value="3PM" {{ $house->guestarrives->checkin_from=='3PM' ? 'selected':'' }}>3PM</option>
								<option value="4PM" {{ $house->guestarrives->checkin_from=='4PM' ? 'selected':'' }}>4PM</option>
								<option value="5PM" {{ $house->guestarrives->checkin_from=='5PM' ? 'selected':'' }}>5PM</option>
								<option value="6PM" {{ $house->guestarrives->checkin_from=='6PM' ? 'selected':'' }}>6PM</option>
								<option value="7PM" {{ $house->guestarrives->checkin_from=='7PM' ? 'selected':'' }}>7PM</option>
								<option value="8PM" {{ $house->guestarrives->checkin_from=='8PM' ? 'selected':'' }}>8PM</option>
								<option value="9PM" {{ $house->guestarrives->checkin_from=='9PM' ? 'selected':'' }}>9PM</option>
								<option value="10PM" {{ $house->guestarrives->checkin_from=='10PM' ? 'selected':'' }}>10PM</option>
								<option value="11PM" {{ $house->guestarrives->checkin_from=='11PM' ? 'selected':'' }}>11PM</option>
								<option value="12AM (midnight)" {{ $house->guestarrives->checkin_from=='12AM (midnight)' ? 'selected':'' }}>12AM (midnight)</option>
							</select>
						</div>
						<div class="col-md-6">
							{{ Form::label('checkin_to', 'To:') }}
							<select class="form-control m-t-10" name="checkin_to">
								<option value="Flexible" {{ $house->guestarrives->checkin_to=='Flexible' ? 'selected':'' }}>Flexible</option>
								<option value="9AM" {{ $house->guestarrives->checkin_to=='9AM' ? 'selected':'' }}>9AM</option>
								<option value="10AM" {{ $house->guestarrives->checkin_to=='10AM' ? 'selected':'' }}>10AM</option>
								<option value="11AM" {{ $house->guestarrives->checkin_to=='11AM' ? 'selected':'' }}>11AM</option>
								<option value="12PM (noon)" {{ $house->guestarrives->checkin_to=='12PM (noon)' ? 'selected':'' }}>12PM (noon)</option>
								<option value="1PM" {{ $house->guestarrives->checkin_to=='1PM' ? 'selected':'' }}>1PM</option>
								<option value="2PM" {{ $house->guestarrives->checkin_to=='2PM' ? 'selected':'' }}>2PM</option>
								<option value="3PM" {{ $house->guestarrives->checkin_to=='3PM' ? 'selected':'' }}>3PM</option>
								<option value="4PM" {{ $house->guestarrives->checkin_to=='4PM' ? 'selected':'' }}>4PM</option>
								<option value="5PM" {{ $house->guestarrives->checkin_to=='5PM' ? 'selected':'' }}>5PM</option>
								<option value="6PM" {{ $house->guestarrives->checkin_to=='6PM' ? 'selected':'' }}>6PM</option>
								<option value="7PM" {{ $house->guestarrives->checkin_to=='7PM' ? 'selected':'' }}>7PM</option>
								<option value="8PM" {{ $house->guestarrives->checkin_to=='8PM' ? 'selected':'' }}>8PM</option>
								<option value="9PM" {{ $house->guestarrives->checkin_to=='9PM' ? 'selected':'' }}>9PM</option>
								<option value="10PM" {{ $house->guestarrives->checkin_to=='10PM' ? 'selected':'' }}>10PM</option>
								<option value="11PM" {{ $house->guestarrives->checkin_to=='11PM' ? 'selected':'' }}>11PM</option>
								<option value="12AM (midnight)" {{ $house->guestarrives->checkin_to=='12AM (midnight)' ? 'selected':'' }}>12AM (midnight)</option>
								<option value="1AM" {{ $house->guestarrives->checkin_to=='12AM (midnight)' ? 'selected':'' }}>1AM</option>
							</select>
						</div>
						<hr>
		    			<h2>Price</h2>

						<div id="hidden_type_single_price" style="display: none;">
						{{ Form::label('single_price', '* Single Room (Standard)', ['class' => 'm-t-10']) }}
						{{ Form::text('single_price', $house->apartmentprices->single_price, ['class' => 'form-control m-t-10', 'placeholder' => '1234']) }}
						</div>

						<div id="hidden_type_deluxe_single_price" style="display: none;">
						{{ Form::label('deluxe_single_price', '* Deluxe Single Room', ['class' => 'm-t-10']) }}
						{{ Form::text('deluxe_single_price', $house->apartmentprices->deluxe_single_price, ['class' => 'form-control m-t-10', 'placeholder' => '1234']) }}
						</div>

						<div id="hidden_type_double_room_price" style="display: none;">
						{{ Form::label('double_price', '* Double Room (Standard)', ['class' => 'm-t-10']) }}
						{{ Form::text('double_price', $house->apartmentprices->double_price, ['class' => 'form-control m-t-10', 'placeholder' => '1234']) }}
						</div>

						<div class="form-check" style="margin-top: 20px;">
					    	<label class="form-check-label">
					        	<input type="radio" class="form-check-input" name="welcome_offer" id="welcome_offer" value="1" {{ $house->apartmentprices->welcome_offer=='1' ? 'checked'  : '' }} style="margin-left: -20px;" checked>
					        	Offer 15% off to your first guest
					      	</label>
					    </div>
					    <div class="form-check">
					    	<label class="form-check-label">
					        	<input type="radio" class="form-check-input" name="welcome_offer" id="welcome_offer" value="0" {{ $house->apartmentprices->welcome_offer=='0' ? 'checked'  : '' }} style="margin-left: -20px;">
					        	No
					      	</label>
					    </div>

						{{ Form::label('discount', '* Discount (%)', ['class' => 'm-t-10']) }}
						{{ Form::text('discount', $house->apartmentprices->discount, ['class' => 'form-control m-t-10', 'placeholder' => '10%']) }}
		    		</div>
		    	</div>
		    </div>
		</div>
	    <div class="col-md-2 float-left">
	    	{{ Form::submit('Save Change', array('class' => 'btn btn-warning m-t-10 pull-right')) }}
			{!! Form::close() !!}
			<a class="btn btn-outline-secondary m-t-10 pull-right" href="{{ route('apartments.owner', $house->id) }}">Back</a>
	    </div>
	</div> 
</div>
@endsection

@section('scripts')
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
	document.getElementById('type_single').addEventListener('change', function () {
		var style = this.value > 0 ? 'block' : 'none';
		document.getElementById('hidden_type_single').style.display = style;
		document.getElementById('hidden_type_single_price').style.display = style;
	});

	document.getElementById('type_deluxe_single').addEventListener('change', function () {
		var style = this.value > 0 ? 'block' : 'none';
		document.getElementById('hidden_type_deluxe_single').style.display = style;
		document.getElementById('hidden_type_deluxe_single_price').style.display = style;
	});

	document.getElementById('type_double_room').addEventListener('change', function () {
		var style = this.value > 0 ? 'block' : 'none';
		document.getElementById('hidden_type_double_room').style.display = style;
		document.getElementById('hidden_type_double_room_price').style.display = style;
	});		
</script>
@endsection
