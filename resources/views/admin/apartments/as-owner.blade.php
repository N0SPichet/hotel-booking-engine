@extends ('admin.layouts.app')
@section ('title', 'Review settings | Apartments')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{route('admin.apartments.index')}}" class="btn btn-outline-secondary">Back</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-8 float-left">
			<h1>Review your settings</h1>
			<h2 align="center">{{ $house->house_title }}
				<small id="showPublish" class="m-t-20" style="font-size: 18px;">
					@if ($house->publish == '2')
					<span class="text-danger"><i class="fas fa-trash"></i> Trash</span>
					@elseif ($house->publish == '1')
					<span class="text-success"><i class="fas fa-eye"></i> Published</span>
					@elseif ($house->publish == '0')
					<span class="text-danger"><i class="fas fa-eye-slash"></i> Private</span>
					@endif
				</small>
			</h2>
			<div class="col-md-12 clear-both">
				<div class="row">
					<h4>Cover Image</h4>
				</div>
				<div class="col-md-6 float-left margin-content">
					<a href="{{ asset('images/houses/'.$house->id.'/'.$house->cover_image) }}"><img src="{{ asset('images/houses/'.$house->id.'/'.$house->cover_image) }}" class="img-responsive" style="border-radius: 2%"></a>
				</div>
				<div class="col-md-6 float-left margin-content">
					<p></p>
				</div>
			</div>
			<div class="col-md-12 clear-both">
				<div class="row float-left">
					<h4>Images</h4>
				</div>
				<div class="row float-left">
					<h4>Overview</h4>
					<div class="gallery">
						@foreach ($house->images as $image)
						@if ($image->room_type == NULL)
						<div class="margin-content box">
							<div class="img-box">
								<a href="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}"><img src="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}" class="img-responsive" style="border-radius: 2%"></a>
								@if ($image->name != $house->cover_image && Auth::user()->id == $house->user_id)
								<a href="{{ route('rooms.detroyimage', $image->id)}}" class="btn btn-default btn-sm with-trash"><i class="fas fa-trash"></i></a>
								@endif
							</div>
						</div>
						@endif
						@endforeach
					</div>
				</div>
				<div class="row float-left">
					<h4>Single Room (Standard)</h4>
					<div class="gallery">
						@foreach ($house->images as $image)
						@if ($image->room_type == '1')
						<div class="margin-content box">
							<div class="img-box">
								<a href="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}"><img src="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}" class="img-responsive" style="border-radius: 2%"></a>
								@if ($image->name != $house->cover_image && Auth::user()->id == $house->user_id)
								<a href="{{ route('rooms.detroyimage', $image->id)}}" class="btn btn-default btn-sm with-trash"><i class="fas fa-trash"></i></a>
								@endif
							</div>
						</div>
						@endif
						@endforeach
					</div>
				</div>
				<div class="row float-left">
					<h4>Deluxe Single Room</h4>
					<div class="gallery">
						@foreach ($house->images as $image)
						@if ($image->room_type == '2')
						<div class="margin-content box">
							<div class="img-box">
								<a href="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}"><img src="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}" class="img-responsive" style="border-radius: 2%"></a>
								@if ($image->name != $house->cover_image && Auth::user()->id == $house->user_id)
								<a href="{{ route('rooms.detroyimage', $image->id)}}" class="btn btn-default btn-sm with-trash"><i class="fas fa-trash"></i></a>
								@endif
							</div>
						</div>
						@endif
						@endforeach
					</div>
				</div>
				<div class="row float-left">
					<h4>Double Room (Standard)</h4>
					<div class="gallery">
						@foreach ($house->images as $image)
						@if ($image->room_type == '3')
						<div class="margin-content box">
							<div class="img-box">
								<a href="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}"><img src="{{ asset('images/houses/'.$house->id.'/'.$image->name) }}" class="img-responsive" style="border-radius: 2%"></a>
								@if ($image->name != $house->cover_image && Auth::user()->id == $house->user_id)
								<a href="{{ route('rooms.detroyimage', $image->id)}}" class="btn btn-default btn-sm with-trash"><i class="fas fa-trash"></i></a>
								@endif
							</div>
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
						<p> How many guests can your place accommodate : {{ $house->house_capacity }} {{ $house->house_capacity>1?'guests':'guest' }}/room </p>
						<p> How many bedrooms : {{ $house->house_bedrooms }} {{ $house->house_bedrooms>1?'rooms':'room' }}</p>
						<p> How many beds : {{ $house->house_beds }} bed/room </p>
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
						@foreach ($house->houseamenities as $amenity)
							<p>{{ $amenity->name }}</p>
						@endforeach
					</div>
				</div>

				<h4>Shared space</h4>
				<div class="card">
					<div class="margin-content">
						@foreach ($house->housespaces as $space)
							<p>{{ $space->name }}</p>
						@endforeach
					</div>
				</div>

				<h4>Your House Rules</h4>
				<div class="card">
					<div class="margin-content">
						@foreach ($house->houserules as $rule)
							<p>{{ $rule->name }}</p>
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
						<p>Single Room (Standard) : {{ $house->apartmentprices->single_price }} Thai baht/night</p>
						<p>Deluxe Single Room : {{ $house->apartmentprices->deluxe_single_price }} Thai baht/night</p>
						<p>Double Room (Standard) : {{ $house->apartmentprices->double_price }} Thai baht/night</p>
						<p>Discount: {{ $house->apartmentprices->discount }}%</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 float-left">
			<div class="col-md-12">
				<div class="dl-horizontal">
					<p><b>Created by</b> <a href="{{route('admin.users.show', $house->user_id)}}">{{ $house->user->user_fname }} {{ $house->user->user_lname }}</a></p>
					<p><b>Created at</b> {{ date("jS M, Y", strtotime($house->created_at)) }}</p>
					<p><b>Last modified</b> {{ $house->updated_at->diffForHumans() }}</p>
				</div>
				@if ($house->publish == 1)
				<div class="margin-content">
				<p>Link to public <a target="_blank" href="{{ route('rooms.show', $house->id) }}" class="btn btn-outline-secondary">Link</a></p>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		
	});

	var lat = {{ $map->map_lat }};
	var lng = {{ $map->map_lng }};

	var map = new google.maps.Map(document.getElementById('map-canvas'), {
		center:{
			lat: lat,
			lng: lng
		},
		zoom: 16
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
