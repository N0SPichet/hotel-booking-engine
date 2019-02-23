@extends ('main')

@section ('title', 'Apartment | Hosting')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
	{!! Html::style('css/select2.min.css') !!}
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
		<div class="col-md-9 float-left">
			<div class="tab-content">
		    	<div id="menu1" class="tab-pane fade active show in">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			{!! Form::open(array('route' => 'apartments.store', 'data-parsley-validate' => '', 'files' => true)) !!}
		    			
		    			<h2>Basic</h2>
		    			{{ Form::label('house_property', '* Is this listing a home, hotel, or something else?') }}
						{{ Form::text('house_property', 'Hotel', array('class' => 'form-control m-t-10', 'required' => '', 'readonly' => '')) }}
						
						{{ Form::label('housetypes_id', '* What type of property is this?') }}
						<select class="form-control m-t-10" name="housetypes_id">
							@foreach ($types as $type)
							<option value="{{ $type->id }}">{{ $type->name }}</option>
							@endforeach
						</select>

						{{ Form::label('type_single', 'Single Room (Standard)', ['class' => 'm-t-10']) }}
						<select id="type_single" name="type_single" class="form-control">
							@for ($i = 0; $i <= 20; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('type_deluxe_single', 'Deluxe Single Room', ['class' => 'm-t-10']) }}
						<select id="type_deluxe_single" name="type_deluxe_single" class="form-control">
							@for ($i = 0; $i <= 20; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('type_double_room', 'Double Room (Standard)', ['class' => 'm-t-10']) }}
						<select id="type_double_room" name="type_double_room" class="form-control">
							@for ($i = 0; $i <= 20; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('house_guestspace', '* What will guests have?', ['class' => 'm-t-10']) }}
						<select class="form-control m-t-10" name="house_guestspace">
							<option value="Entrie">Entrie place</option>
							<option value="Private">Private room</option>
							<option value="Shared">Shared room</option>
						</select>

						{{ Form::label('house_capacity', '* How many guests can your place accommodate each room?', ['class' => 'm-t-10']) }}
						<select id="house_capacity" name="house_capacity" class="form-control" required="">
							@for ($i = 1; $i<=8; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>

						<h2>Rooms</h2>
						{{ Form::label('house_bedrooms', '* How many bedrooms in each room?', ['class' => 'm-t-10']) }}
						<select id="house_bedrooms" name="house_bedrooms" class="form-control" required="">
							@for ($i = 1; $i <= 4; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('house_beds', '* How many beds in each room?', ['class' => 'm-t-10']) }}
						<select id="house_beds" name="house_beds" class="form-control" required="">
							@for ($i = 1; $i <= 4; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('house_bathroom', '* How many bathrooms in each room?', ['class' => 'm-t-10']) }}
						<select id="house_bathroom" name="house_bathroom" class="form-control" required="">
							@for ($i = 1; $i <= 4; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>

						{{ Form::label('house_bathroomprivate', '* Is the bathroom private?', ['class' => 'm-t-10']) }}
						<div class="form-check">
					    	<label class="form-check-label" >
					        <input type="radio" class="form-check-input" name="house_bathroomprivate" id="house_bathroomprivate" value="1" style="margin-left: -20px;" checked>
					        	Yes
					      	</label>
					    </div>
					    <div class="form-check">
					    	<label class="form-check-label">
					        	<input type="radio" class="form-check-input" name="house_bathroomprivate" id="house_bathroomprivate" value="0" style="margin-left: -20px;">
					        	No
					      	</label>
					    </div>
		    		</div>
		    	</div>

		    	<div id="menu2" class="tab-pane fade">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Address and Map</h2>
		    			{{ Form::label('province_id', '* Provinces', ['class' => 'm-t-10']) }}
						<select class='form-control' name="province_id" id='province_id'>
							<option value="0">Select Provinces</option>
							@foreach ($provinces as $province)
							<option value="{{ $province->id }}" {{ $province->id===1? 'selected':'' }}>{{ $province->name }}</option>
							@endforeach
						</select>
						{{ Form::label('district_id', '* Districts', ['class' => 'm-t-10']) }}
						<select name="district_id" id="district_id" class="form-control">
							<option value="0">Select Districts</option>
							@foreach ($districts as $district)
							<option value="{{ $district->id }}" {{ $district->id===1? 'selected':'' }}>{{ $district->name }}</option>
							@endforeach
						</select>
						{{ Form::label('sub_district_id', '* Sub Districts', ['class' => 'm-t-10']) }}
						<select name="sub_district_id" id="sub_district_id" class="form-control">
							<option value="0">Select Sub Districts</option>
							@foreach ($sub_districts as $sub_district)
							<option value="{{ $sub_district->id }}" {{ $sub_district->id===1? 'selected':'' }}>{{ $sub_district->name }}</option>
							@endforeach
						</select>
						{{ Form::label('house_address', '* Street Address', ['class' => 'm-t-10']) }}
						{{ Form::text('house_address', null, array('class' => 'form-control m-t-10', 'required' => '')) }}
						{{ Form::label('house_postcode', '* ZIP Code', ['class' => 'm-t-10']) }}
						{{ Form::text('house_postcode', null, array('class' => 'form-control m-t-10', 'id' => 'postal_code')) }}
						<label>Map <small>you can move marker if it's not point to correct position</small></label>
						<input type="text" id="searchmap">
						<div id="map-canvas"></div>
						<input type="hidden" class="form-control input-sm" id="lat" name="map_lat">
						<input type="hidden" class="form-control input-sm" id="lng" name="map_lng">
		    		</div>
		    	</div>

		    	<div id="menu3" class="tab-pane fade">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Amenities</h2>
					    {{ Form::label('houseamenities', '* What amenities do you offer?', ['class' => 'm-t-10']) }}
						<div class="row ">
						@foreach ($houseamenities as $amenity)
							<div class="col-md-6" >
								{{ Form::checkbox('houseamenities[]', $amenity->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "amenity$amenity->id"]) }}
								{{ Form::label('amenity' . $amenity->id, $amenity->name) }}
							</div>
						@endforeach
						</div>

						<h2>Space</h2>
						{{ Form::label('housespaces', '* What spaces can guests use?', ['class' => 'm-t-10']) }}
						<div class="row">
						@foreach ($spaces as $space)
							<div class="col-md-6">
							{{ Form::checkbox('housespaces[]', $space->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "space$space->id"]) }}
							{{ Form::label('space' . $space->id, $space->name) }}
							</div>
						@endforeach
						</div>
		    		</div>
		    	</div>

		    	<div id="menu4" class="tab-pane fade">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Title</h2>
		    			{{ Form::label('house_title', '* House Title: ', ['class' => 'm-t-10']) }}
						{{ Form::text('house_title', null, array('class' => 'form-control', 'required' => '')) }}

						<h2>Description</h2>
						{{ Form::label('house_description', '* Short description of your house', ['class' => 'm-t-10']) }}
						{{ Form::textarea('house_description', null, array('class' => 'form-control m-t-10', 'rows' => '5')) }}
							
						{{ Form::label('about_your_place', 'About your place (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('about_your_place', null, ['class' => 'form-control m-t-10', 'rows' => '5']) }}

						{{ Form::label('guest_can_access', 'What guests can access (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('guest_can_access', null, ['class' => 'form-control m-t-10', 'rows' => '5']) }}

						{{ Form::label('optional_note', 'Other things to note (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('optional_note', null, ['class' => 'form-control m-t-10', 'rows' => '5']) }}

						<h2>The neighborhood</h2>
						{{ Form::label('about_neighborhood', 'About the neighborhood (optional)', ['class' => 'm-t-10']) }}
						{{ Form::textarea('about_neighborhood', null, ['class' => 'form-control m-t-10']) }}
		    		</div>
		    	</div>

		    	<div id="menu5" class="tab-pane fade">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Photos</h2>
		    			{{ Form::label('image_names', '* Images', ['class' => 'm-t-10']) }}
						{{ Form::file('image_names[]', array('class' => 'form-control-file', 'multiple' => 'multiple')) }}

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

		    	<div id="menu6" class="tab-pane fade">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Rules</h2>
		    			{{ Form::label('houserules', '* Set your house rules', ['class' => 'm-t-10']) }}
						<div class="row">
						@foreach ($rules as $rule)
						<div class="col-md-12">
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
						<div class="col-md-6">
							{{ Form::checkbox('housedetails[]', $detail->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "details$detail->id"]) }}
							{{ Form::label('details' . $detail->id, $detail->name) }}
						</div>
						@endforeach
						</div>
		    		</div>
		    	</div>

		    	<div id="menu7" class="tab-pane fade">
		    		<div class="col-md-10 col-md-offset-1 m-t-10">
		    			<h2>Availability</h2>
		    			{{ Form::label('notice', '* How much notice do you need before a guest arrives?', ['class' => 'm-t-10']) }}
						<select class="form-control m-t-10" name="notice">
							<option value="Same Day">Same Day</option>
							<option value="1 Day">1 Day</option>
							<option value="2 Days">2 Days</option>
							<option value="3 Days">3 Days</option>
							<option value="7 Days">7 Days</option>
						</select>

		    			<p class="m-t-10"><b>* When can guests check in?</b></p>
						<div class="col-md-6">
							{{ Form::label('checkin_from', 'From:') }}
							<select class="form-control m-t-10" name="checkin_from">
								<option value="Flexible">Flexible</option>
								<option value="8AM">8AM</option>
								<option value="9AM">9AM</option>
								<option value="10AM">10AM</option>
								<option value="11AM">11AM</option>
								<option value="12PM (noon)">12PM (noon)</option>
								<option value="1PM">1PM</option>
								<option value="2PM">2PM</option>
								<option value="3PM">3PM</option>
								<option value="4PM">4PM</option>
								<option value="5PM">5PM</option>
								<option value="6PM">6PM</option>
								<option value="7PM">7PM</option>
								<option value="8PM">8PM</option>
								<option value="9PM">9PM</option>
								<option value="10PM">10PM</option>
								<option value="11PM">11PM</option>
								<option value="12AM (midnight)">12AM (midnight)</option>
							</select>
						</div>
						<div class="col-md-6">
							{{ Form::label('checkin_to', 'To:') }}
							<select class="form-control m-t-10" name="checkin_to">
								<option value="Flexible">Flexible</option>
								<option value="9AM">9AM</option>
								<option value="10AM">10AM</option>
								<option value="11AM">11AM</option>
								<option value="12PM (noon)">12PM (noon)</option>
								<option value="1PM">1PM</option>
								<option value="2PM">2PM</option>
								<option value="3PM">3PM</option>
								<option value="4PM">4PM</option>
								<option value="5PM">5PM</option>
								<option value="6PM">6PM</option>
								<option value="7PM">7PM</option>
								<option value="8PM">8PM</option>
								<option value="9PM">9PM</option>
								<option value="10PM">10PM</option>
								<option value="11PM">11PM</option>
								<option value="12AM (midnight)">12AM (midnight)</option>
								<option value="1AM">1AM</option>
							</select>
						</div>
						<hr>
						<h2>Price</h2>

						<div id="hidden_type_single_price" style="display: none;">
						{{ Form::label('single_price', '* Single Room (Standard)', ['class' => 'm-t-10']) }}
						{{ Form::text('single_price', null, ['class' => 'form-control m-t-10', 'placeholder' => '1234']) }}
						</div>

						<div id="hidden_type_deluxe_single_price" style="display: none;">
						{{ Form::label('deluxe_single_price', '* Deluxe Single Room', ['class' => 'm-t-10']) }}
						{{ Form::text('deluxe_single_price', null, ['class' => 'form-control m-t-10', 'placeholder' => '1234']) }}
						</div>

						<div id="hidden_type_double_room_price" style="display: none;">
						{{ Form::label('double_price', '* Double Room (Standard)', ['class' => 'm-t-10']) }}
						{{ Form::text('double_price', null, ['class' => 'form-control m-t-10', 'placeholder' => '1234']) }}
						</div>

						<div class="form-check" style="margin-top: 20px;">
					    	<label class="form-check-label">
					        	<input type="radio" class="form-check-input" name="welcome_offer" id="welcome_offer" value="1" style="margin-left: -20px;" checked>
					        	Offer 15% off to your first guest
					      	</label>
					    </div>
					    <div class="form-check">
					    	<label class="form-check-label">
					        	<input type="radio" class="form-check-input" name="welcome_offer" id="welcome_offer" value="0" style="margin-left: -20px;">
					        	No
					      	</label>
					    </div>

						{{ Form::label('discount', '* Discount (%)', ['class' => 'm-t-10']) }}
						{{ Form::text('discount', null, ['class' => 'form-control m-t-10', 'placeholder' => '10%']) }}
		    		</div>
		    	</div>
		    </div>
		</div>
		<div class="col-md-1 float-left">
			{{ Form::submit('Save Change', array('class' => 'btn btn-success form-spacing-top pull-right')) }}
			{!! Form::close() !!}
		</div>
	</div> 
</div>
@endsection

@section('scripts')
	<script type="text/javascript">

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

		var map = new google.maps.Map(document.getElementById('map-canvas'), {
			center:{
				lat: 7.897597,
				lng: 98.353430
			},
			zoom: 15
		});

		var marker = new google.maps.Marker({
			position:{
				lat: 7.897597,
				lng: 98.353430
			},
			map: map,
			draggable: true
		});

		var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));

		google.maps.event.addListener(searchBox, 'places_changed', function(){
			var places = searchBox.getPlaces();
			var bounds = new google.maps.LatLngBounds();
			var i, place;

			for (var i = 0; place=places[i]; i++) {
				bounds.extend(place.geometry.location);
				marker.setPosition(place.geometry.location);
			}

			map.fitBounds(bounds);
			map.setZoom(15);
		});

		google.maps.event.addListener(marker, 'position_changed', function(){
			var lat = marker.getPosition().lat();
			var lng = marker.getPosition().lng();

			$('#lat').val(lat);
			$('#lng').val(lng);
		});

	</script>
@endsection