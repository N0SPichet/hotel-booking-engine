@extends ('main')

@section ('title', 'Maps')

@section ('content')
<div class="container">
	<div class="col-sm-8">
		<h1>Locations</h1>
		<h1>{{ $map->map_name }}</h1>
		<div id="map-canvas">
			
		</div>
	</div>
</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		var lat = {{ $map->map_lat }};
		var lng = {{ $map->map_lng }};

		var map = new google.maps.Map(document.getElementById('map-canvas'), {
			center:{
				lat: lat,
				lng: lng
			},
			zoom: 15
		});

		var circle = new google.maps.Circle({
			position:{
				lat: lat,
				lng: lng
			},
			strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#0000FF',
            fillOpacity: 1,
            map: map,
            center: {lat: lat, lng: lng},
            radius: Math.sqrt(10) * 100
		});
	</script>
@endsection