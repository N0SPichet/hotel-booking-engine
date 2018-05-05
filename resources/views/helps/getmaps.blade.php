@extends ('main')

@section ('title', 'Maps')

@section ('content')
<div class="container">
	<div class="col-sm-6">
		<h1>Locations</h1>
		{!! Form::open(['route' => 'maps.store', 'files' => true, 'method' => 'POST']) !!}
			<div class="form-group">
				<label for="map_name">Place Name</label>
				<input type="text" class="form-control input-sm" name="map_name">

				<label>Map</label>
				<input type="text" id="searchmap">
				<div id="map-canvas"></div>

				<label>Latitude</label>
				<input type="text" class="form-control input-sm" id="lat" name="map_lat">

				<label>Longitude</label>
				<input type="text" class="form-control input-sm" id="lng" name="map_lng">

				<button class="btn btn-sm btn-danger">Save</button>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
	<script type="text/javascript">
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