@extends ('main')

@section ('title', 'Review your settings | Apartments')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-8">
			<h1>Review your settings</h1>
			<h2 align="center">
				{{ $house->house_title }}
				<small >
					@if ($house->publish == '2')
					<span class="text-success margin-top-20"><i class="fas fa-eye"></i> Published</span>
					@elseif ($house->publish == '0')
					<span class="text-danger margin-top-20"><i class="fas fa-eye-slash"></i> Private</span>
					@endif
				</small>
			</h2>
			<div class="col-md-12">
				<div class="row">
					<h4>Cover Image</h4>
				</div>
				<div class="col-md-6">
					<a id="single_image" href="{{ asset('images/houses/' . $house->cover_image) }}"><img src="{{ asset('images/houses/' . $house->cover_image) }}" class="img-responsive" style="border-radius: 5%"></a>
				</div>
				<div class="col-md-6">
					
				</div>
			</div>
			<div class="col-md-12">
				<div class="row">
					<h4>Images</h4>
					<div class="gallery">
						<h4>Overview</h4>
						@foreach ($images as $image)
						@if ($image->room_type == NULL)
						<div class="col-md-4">
							<a id="single_image" href="{{ asset('images/houses/' . $image->image_name) }}"><img src="{{ asset('images/houses/' . $image->image_name) }}" class="img-responsive" style="border-radius: 5%"></a>
							@if ($image->image_name != $house->cover_image && $house->users_id == Auth::user()->id)
							<a href="{{ route('rooms.detroyimage', $image->id)}}" style="position: absolute; top:2px; right: : 2px; z-index: 100;" class="btn btn-default btn-sm"><i class="fas fa-trash"></i></a>
							@endif
							<br>
						</div>
						@endif
						@endforeach
					</div>
				</div>
				<div class="row">
					<div class="gallery">
						<h4>Single Room (Standard)</h4>
						@foreach ($images as $image)
						@if ($image->room_type == '1')
						<div class="col-md-4">
							<a id="single_image" href="{{ asset('images/houses/' . $image->image_name) }}"><img src="{{ asset('images/houses/' . $image->image_name) }}" class="img-responsive" style="border-radius: 5%"></a>
							@if ($image->image_name != $house->cover_image && $house->users_id == Auth::user()->id)
							<a href="{{ route('rooms.detroyimage', $image->id)}}" style="position: absolute; top:2px; right: : 2px; z-index: 100;" class="btn btn-default btn-sm"><i class="fas fa-trash"></i></a>
							@endif
							<br>
						</div>
						@endif
						@endforeach
					</div>
				</div>
				<div class="row">
					<div class="gallery">
						<h4>Deluxe Single Room</h4>
						@foreach ($images as $image)
						@if ($image->room_type == '2')
						<div class="col-md-4">
							<a id="single_image" href="{{ asset('images/houses/' . $image->image_name) }}"><img src="{{ asset('images/houses/' . $image->image_name) }}" class="img-responsive" style="border-radius: 5%"></a>
							@if ($image->image_name != $house->cover_image && $house->users_id == Auth::user()->id)
							<a href="{{ route('rooms.detroyimage', $image->id)}}" style="position: absolute; top:2px; right: : 2px; z-index: 100;" class="btn btn-default btn-sm"><i class="fas fa-trash"></i></a>
							@endif
							<br>
						</div>
						@endif
						@endforeach
					</div>
				</div>
				<div class="row">
					<div class="gallery">
						<h4>Double Room (Standard)</h4>
						@foreach ($images as $image)
						@if ($image->room_type == '3')
						<div class="col-md-4">
							<a id="single_image" href="{{ asset('images/houses/' . $image->image_name) }}"><img src="{{ asset('images/houses/' . $image->image_name) }}" class="img-responsive" style="border-radius: 5%"></a>
							@if ($image->image_name != $house->cover_image && $house->users_id == Auth::user()->id)
							<a href="{{ route('rooms.detroyimage', $image->id)}}" style="position: absolute; top:2px; right: : 2px; z-index: 100;" class="btn btn-default btn-sm"><i class="fas fa-trash"></i></a>
							@endif
							<br>
						</div>
						@endif
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<h4>Room</h4>
				<div class="card">
					<div class="margin-content">
						<p> Room Description {!! $house->house_description !!}</p>
						<hr>
						<p> About your place (optional) {!! $house->about_your_place !!}</p>
						<hr>
						<p> What guests can access (optional) {!! $house->guest_can_access !!}</p>
						<hr>
						<p> Other things to note (optional) {!! $house->optional_note !!}</p>
						<hr>
						<p> About the neighborhood (optional) {!! $house->about_neighborhood !!} </p>
						<hr>
						<p> Type of property : {{ $house->house_property }} </p>
						<hr>
						<p> Guests have : {{ $house->house_guestspace }} </p>
					</div>
				</div>

				<h4>Bedroom</h4>
				<div class="card">
					<div class="margin-content">
						<p> How many guests can your place accommodate : {{ $house->house_capacity }} guest </p>
						<p> How many bedrooms : {{ $house->house_bedrooms }} room </p>
						<p> How many beds : {{ $house->house_beds }} bed </p>
					</div>
				</div>

				<h4>Bathroom</h4>
				<div class="card">
					<div class="margin-content">
						<p> How many bathrooms : {{ $house->house_bathroom }} room </p>
						<p> Is the bathroom private :  
							@if ($house->house_bathroomprivate == 1)
								Yes
							@elseif ($house->house_bathroomprivate != 1)
								No
							@endif
						</p>
					</div>
				</div>

				<h4>Address</h4>
				<div class="card">
					<div class="margin-content">
						<p> {{ $house->house_address }} {{ $house->sub_district->name }} {{ $house->district->name }}, {{ $house->province->name }} </p>
						<p>Postcode {{ $house->house_postcode }} </p>
					</div>
						<div id="map-canvas"></div>
					
				</div>

				<h4>Amenities</h4>
				<div class="card">
					<div class="margin-content">
						@foreach ($house->houseamenities as $houseamenity)
							<p>{{ $houseamenity->amenityname }}</p>
						@endforeach
					</div>
				</div>

				<h4>Shared space</h4>
				<div class="card">
					<div class="margin-content">
						@foreach ($house->housespaces as $housespace)
							<p>{{ $housespace->spacename }}</p>
						@endforeach
					</div>
				</div>

				<h4>Your House Rules</h4>
				<div class="card">
					<div class="margin-content">
						@foreach ($house->houserules as $houserule)
							<p>{{ $houserule->houserule_name }}</p>
						@endforeach
						@if ($house->optional_rules)
						<br>
						<p> {{ $house->optional_rules }}</p>
						@endif
					</div>
				</div>

				<h4>Availability</h4>
				<div class="card">
					<div class="margin-content">
						@if ($house->apartmentprices->type_single)
						<p>Single Room (Standard) : {{ $house->apartmentprices->type_single }} {{ $house->apartmentprices->type_single > 1 ? 'rooms':'room' }}.</p>
						@endif
						@if ($house->apartmentprices->type_deluxe_single)
						<p>Deluxe Single Room : {{ $house->apartmentprices->type_deluxe_single }} {{ $house->apartmentprices->type_deluxe_single > 1 ? 'rooms':'room' }}.</p>
						@endif
						@if ($house->apartmentprices->type_double_room)
						<p>Double Room (Standard) : {{ $house->apartmentprices->type_double_room }} {{ $house->apartmentprices->type_double_room > 1 ? 'rooms':'room' }}.</p>
						@endif

						<p>Advance notice: {{$house->guestarrives->notice }}</p>
						@if ($house->guestarrives->checkin_to == 'Flexible')
						<p>Check-in: Anytime after {{ $house->guestarrives->checkin_from }}</p>
						@else
						<p>Check-in: {{ $house->guestarrives->checkin_from }} - {{ $house->guestarrives->checkin_to }}</p>
						@endif
					</div>
				</div>

				<h4>Pricing</h4>
				<div class="card">
					<div class="margin-content">
						<p>Single Room (Standard) : {{ $house->apartmentprices->single_price }} Thai Baht/Night</p>
						<p>Deluxe Single Room : {{ $house->apartmentprices->deluxe_single_price }} Thai Baht/Night</p>
						<p>Double Room (Standard) : {{ $house->apartmentprices->double_price }} Thai Baht/Night</p>
						<p>Discount: {{ $house->apartmentprices->discount }}%</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="well">
			<div class="dl-horizontal">
					<dt>Created by</dt>
					<dd>{{ $house->users->user_fname }} {{ $house->users->user_lname }}</dd>
					<dt>Created at</dt>
					<dd>{{ date("jS M, Y", strtotime($house->created_at)) }}</dd>
					<dt>Date modified</dt>
					<dd>{{ date("jS M, Y", strtotime($house->updated_at)) }}</dd>
				</div>
				<div class="margin-content">
				<p>Link to public <a href="{{ route('rooms.show', $house->id) }}" class="btn btn-outline-secondary">Link</a></p>
				</div>
				@if ($house->users_id == Auth::user()->id)
				<div class="row">
					<div class="col-sm-4 float-left">
						<a id="publish" class="btn btn-outline-info btn-block btn-h1-spacing">Publish</a>
					</div>
					<div class="col-sm-4 float-left">
						{!! Html::linkRoute('apartments.edit', 'Edit', array($house->id), array('class' => 'btn btn-outline-warning btn-block btn-h1-spacing')) !!}
					</div>
					<div class="col-sm-4 float-left">
						{!! Form::open(['route' => ['apartments.destroy', $house->id], 'method' => 'DELETE']) !!}
							{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block btn-h1-spacing']) !!}
							{!! Form::close() !!}
					</div>
				</div>
				@endif
				<hr>
				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute('apartments.index-myapartment', 'Back to My Room', array(Auth::user()->id), array('class' => 'btn btn-outline-secondary')) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	{!! Html::script('js/select2.min.js') !!}
	<script type="text/javascript">
		$('.select2-multi').select2();

		$(document).ready(function() {

			/* This is basic - uses default settings */
			
			$("a#single_image").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	200, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
			});
			
			/* Using custom settings */
			
			$("a#inline").fancybox({
				'hideOnContentClick': true
			});

			/* Apply fancybox to multiple items */
			
			$("a.group").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
			});

			$('#publish').on('click', function() {
				$.ajax({
					type: 'get',
					url: '{{ route('api.rooms.publish', $house->id) }}',
					data: {},
					success: function(response) {
						if (response.data == 1) {
							$('#showPublish').html('<span class="text-success margin-top-20"><i class="fas fa-eye"></i> Published</span>')
						}
						else if(response.data == 0) {
							$('#showPublish').html('<span class="text-danger margin-top-20"><i class="fas fa-eye-slash"></i> Private</span>')
						}
					}
				});
			});
		});

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
            fillOpacity: 0.3,
            map: map,
            center: {lat: lat, lng: lng},
            radius: Math.sqrt(10) * 60
		});
	</script>
@endsection