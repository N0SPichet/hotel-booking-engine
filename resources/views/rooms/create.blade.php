@extends ('dashboard.main')
@section ('title', 'Room | Hosting')
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
		<div class="col-md-9 float-left">
			<div class="tab-content">
				<div id="menu1" class="tab-pane fade show active in">
					<div class="col-md-10 col-md-offset-1 m-t-10">
						{!! Form::open(array('route' => 'rooms.store', 'data-parsley-validate' => '', 'files' => true)) !!}
						<h2>Basic</h2>
						{{ Form::label('house_property', '* Is this listing a home, hotel, or something else?', ['class' => 'm-t-10']) }}
						<select class="form-control m-t-10" name="house_property">
							<option value="home">Home</option>
							<option value="hotel">Hotel</option>
							<option value="something">Something else</option>
						</select>
						{{ Form::label('housetype_id', '* What type of property is this?', ['class' => 'm-t-10']) }}
						<select class="form-control m-t-10" name="housetype_id">
							<option value="0" disabled="">Select Type</option>
							@foreach ($types as $type)
							<option value="{{ $type->id }}">{{ $type->name }}</option>
							@endforeach
						</select>
						{{ Form::label('house_guestspace', '* What will guests have?', ['class' => 'm-t-10']) }}
						<select class="form-control m-t-10" name="house_guestspace">
							<option value="Entrie">Entrie place</option>
							<option value="Private">Private room</option>
							<option value="Shared">Shared room</option>
						</select>
						{{ Form::label('house_capacity', '* How many guests can your place accommodate?', ['class' => 'm-t-10']) }}
						<select id="house_capacity" name="house_capacity" class="form-control" required="">
							@for ($i = 1; $i<=8; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
						<h2>Rooms</h2>
						{{ Form::label('house_bedrooms', '* How many bedrooms can guests use?', ['class' => 'm-t-10']) }}
						<select id="house_bedrooms" name="house_bedrooms" class="form-control" required="">
							@for ($i = 1; $i <= 4; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
						{{ Form::label('house_beds', '* How many beds can guests use?', ['class' => 'm-t-10']) }}
						<select id="house_beds" name="house_beds" class="form-control" required="">
							@for ($i = 1; $i <= 4; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
						{{ Form::label('house_bathroom', '* How many bathrooms?', ['class' => 'm-t-10']) }}
						<select id="house_bathroom" name="house_bathroom" class="form-control" required="">
							@for ($i = 1; $i <= 4; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
						{{ Form::label('house_bathroomprivate', '* Is the bathroom private?', ['class' => 'm-t-10']) }}
						<div class="form-check">
							<label class="form-check-label">
							<input type="radio" class="form-check-input" name="house_bathroomprivate" id="house_bathroomprivate" value="1" style="margin-left: -20px;">
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
				<div id="menu2" class="tab-pane fade show">
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
						{{ Form::text('house_address', null, array('class' => 'form-control m-t-10')) }}
						{{ Form::label('house_postcode', '* ZIP Code', ['class' => 'm-t-10']) }}
						{{ Form::text('house_postcode', null, array('class' => 'form-control m-t-10', 'id' => 'postal_code')) }}
						<label class="m-t-10">Map <small>you can move marker if it's not point to correct position</small></label>
						<input type="text" id="searchmap" class="form-control">
						<div id="map-canvas" class="m-t-10"></div>
						<input type="hidden" class="form-control input-sm" id="lat" name="map_lat">
						<input type="hidden" class="form-control input-sm" id="lng" name="map_lng">
					</div>
				</div>
				<div id="menu3" class="tab-pane fade show">
					<div class="col-md-10 col-md-offset-1 m-t-10">
						<h2>Amenities</h2>
						{{ Form::label('houseamenities', '* What amenities do you offer?', ['class' => 'm-t-10']) }}
						<div class="row ">
							@foreach ($houseamenities as $amenity)
							<div class="col-md-6" >
								{{ Form::checkbox('houseamenities[]', $amenity->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "amenity$amenity->id"]) }}
								{{ Form::label('amenity' . $amenity->id, $amenity->amenityname) }}
							</div>
							@endforeach
						</div>
						<h2>Space</h2>
						{{ Form::label('housespaces', '* What spaces can guests use?', ['class' => 'm-t-10']) }}
						<div class="row">
							@foreach ($housespaces as $space)
							<div class="col-md-6">
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
						{{ Form::text('house_title', null, array('class' => 'form-control', 'required' => '', "data-parsley-trigger"=>"keyup", "data-parsley-minlength"=>"8", "data-parsley-maxlength"=>"100", "data-parsley-minlength-message"=>"Title should be 8 characters long.")) }}
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
				<div id="menu5" class="tab-pane fade show">
					<div class="col-md-10 col-md-offset-1 m-t-10">
						<h2>Photos</h2>
						{{ Form::label('image_names', '* Images', ['class' => 'm-t-10']) }}
						{{ Form::file('image_names[]', array('class' => 'form-control-file', 'multiple' => 'multiple')) }}
					</div>
				</div>
				<div id="menu6" class="tab-pane fade show">
					<div class="col-md-10 col-md-offset-1 m-t-10">
						<h2>Rules</h2>
						{{ Form::label('houserules', '* Set your house rules', ['class' => 'm-t-10']) }}
						<div class="row">
							@foreach ($houserules as $houserule)
							<div class="col-md-12">
								{{ Form::checkbox('houserules[]', $houserule->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "houserules$houserule->id"]) }}
								{{ Form::label('houserules' . $houserule->id, $houserule->houserule_name) }}
							</div>
							@endforeach
						</div>
						{{ Form::label('optional_rules', 'Rules (Optional)', ['class' => 'm-t-10']) }}
						{{ Form::text('optional_rules', null, ['class' => 'form-control m-t-10']) }}
						{{ Form::label('housedetails', '* Details guests must know about your home', ['class' => 'm-t-10']) }}
						<div class="row">
							@foreach ($housedetails as $housedetail)
							<div class="col-md-6">
								{{ Form::checkbox('housedetails[]', $housedetail->id, null, ['class' => 'field', 'multiple' => 'multiple', 'id' => "housedetails$housedetail->id"]) }}
								{{ Form::label('housedetails' . $housedetail->id, $housedetail->must_know) }}
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
						<h2>Price</h2>
						<p class="m-t-10"><b>* This price for per person or for a day?</b></p>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="inlinetype_price1" name="type_price" value="1">
							<label class="form-check-label" for="inlinetype_price1">Per Person</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="inlinetype_price2" name="type_price" value="2">
							<label class="form-check-label" for="inlinetype_price2">Per Day</label>
						</div>
						{{ Form::label('price', '* Room price (THB)', ['class' => 'm-t-10']) }}
						{{ Form::text('price', null, ['class' => 'form-control m-t-10', 'placeholder' => '1234', 'required' => '']) }}
						{{ Form::label('food_price', '* Food price (THB) (optional)', ['class' => 'm-t-10']) }}
						{{ Form::text('food_price', null, ['class' => 'form-control m-t-10', 'placeholder' => '1234']) }}
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="food_breakfast" value="1">
							<label class="form-check-label" for="inlineCheckbox1">Breakfast</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="food_lunch" value="1">
							<label class="form-check-label" for="inlineCheckbox2">Lunch</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="food_dinner" value="1">
							<label class="form-check-label" for="inlineCheckbox3">Dinner</label>
						</div>
						<div class="form-check" style="m-t: 20px;">
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
						{{ Form::label('weekly_discount', '* Weekly discount (%)', ['class' => 'm-t-10']) }}
						{{ Form::text('weekly_discount', null, ['class' => 'form-control m-t-10', 'placeholder' => '10%']) }}
						{{ Form::label('monthly_discount', '* Monthly discount (%)', ['class' => 'm-t-10']) }}
						{{ Form::text('monthly_discount', null, ['class' => 'form-control m-t-10', 'placeholder' => '10%']) }}
					</div>
				</div>
			</div>
		</div>
		<div class="col-1 float-left">
			{{ Form::submit('Save Change', array('class' => 'btn btn-success form-spacing-top pull-right')) }}
			{!! Form::close() !!}
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
	});
</script>
@endsection
