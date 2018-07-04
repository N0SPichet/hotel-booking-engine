@extends ('main')

@section ('title', 'Apartment Detail')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container">
	<div class="row">
		<h2><img src="{{ asset('images/houses/apartment.png')}}" style="width: 35px; margin-bottom: 10px;"> Room : {{ $house->house_title }} <small>{{ $house->house_guestspace }} space</small></h2>
	</div>
	<div class="row">
		<div class="card col-md-12 col-sm-12" align="center">
			{!! Form::open(array('route' => 'rentals.agreement', 'data-parsley-validate' => '')) !!}
			<div class="col-md-4 col-sm-4">
				<div class="form-group margin-top-10">
		    		<i class="far fa-calendar-alt"></i>
					{{ Form::label('datein', 'Check In') }}
					{{ Form::text('datein', null, array('class' => 'form-control', 'required' => '', 'id' => 'datein')) }}
		  		</div>
			</div>
			<div class="col-md-4 col-sm-4">
				<div class="form-group margin-top-10">
		    		<i class="far fa-calendar-alt"></i>
					{{ Form::label('dateout', 'Check Out') }}
					{{ Form::text('dateout', null, array('class' => 'form-control', 'required' => '', 'id' => 'dateout')) }}
		  		</div>
			</div>
		</div>
		<div class="card col-md-12 col-sm-12">
			<div class="form-group margin-top-10">
				<p class="text-success">Available rooms</p>
				<div class="form-inline" class="margin-top-10">
					@if ($house->apartmentprices->type_single)
					{{ Form::label('type_single', 'Single Room (Standard)', ['style' => 'width: 300px;']) }}
					<select class="form-control" id="type_single" name="type_single" style="width: 70px;">
						@for ($i = 0; $i <= $house->apartmentprices->type_single ; $i++ )
						<option value="{{ $i }}">{{ $i }}</option>
						@endfor
					</select>
					<span class="margin-content">{{$house->apartmentprices->single_price}} Thai Baht/Night</span>
					@endif
				</div>
				<div class="form-inline" class="margin-top-10">
					@if ($house->apartmentprices->type_deluxe_single)
					{{ Form::label('type_deluxe_single', 'Deluxe Single Room', ['style' => 'width: 300px;']) }}
					<select class="form-control" id="type_deluxe_single" name="type_deluxe_single" style="width: 70px;">
						@for ($i = 0; $i <= $house->apartmentprices->type_deluxe_single ; $i++ )
						<option value="{{ $i }}">{{ $i }}</option>
						@endfor
					</select>
					<span class="margin-content">{{$house->apartmentprices->deluxe_single_price}} Thai Baht/Night</span>
					@endif
				</div>
				<div class="form-inline" class="margin-top-10">
					@if ($house->apartmentprices->type_double_room)
					{{ Form::label('type_double_room', 'Double Room (Standard)', ['style' => 'width: 300px;']) }}
					<select class="form-control" id="type_double_room" name="type_double_room" style="width: 70px;">
						@for ($i = 0; $i <= $house->apartmentprices->type_double_room ; $i++ )
						<option value="{{ $i }}">{{ $i }}</option>
						@endfor
					</select>
					<span class="margin-content">{{$house->apartmentprices->double_price}} Thai Baht/Night</span>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-12" align="center">
			<div class="form-group margin-top-10">
				{{ Form::hidden('id', $house->id, array('class' => 'form-control input-lg')) }}
				<button type="submit" class="btn btn-success btn-h1-spacing">Request to Book</button>
			{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h2>Hosted by <a href="/users/{{ $house->users->id }}" target="_blank" style="text-decoration-line: none;">{{ $house->users->user_fname }}</a> @if ($house->users->user_verifications->verify == '1') <small style="color: green;"><i class="far fa-check-circle"></i></small> @endif</h2>
			<p>{{ $house->addressstates->state_name }}, {{ $house->addresscountries->country_name }}</p>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="card" style="width: 100%;">
					<div class="margin-content">
						<p>{!! $house->users->user_description !!}</p>
					</div>
				</div>
			</div>
			<div>
				<a href="{{ route('getcontacthost', $house->users->id) }}" target="_blank" class="btn btn-info btn-sm form-spacing-top-8"><i class="fas fa-envelope"></i> Contact Host</a>
			</div>
			<br>
			<div class="row">
				<div class="card">
					<div class="gallery margin-top-10">
						@foreach ($images as $image)
						<div class="col-md-4">
							<a id="single_image" href="{{ asset('images/houses/' . $image->image_name) }}"><img src="{{ asset('images/houses/' . $image->image_name) }}" class="img-responsive" style="border-radius: 5%"></a>
							<br>
						</div>
						@endforeach
					</div>
				</div>
			</div>
  			<h2>The neighborhood</h2>
			<div class="row">
				<div class="card" style="width: 100%;">
					<div class="margin-content">
						<p>{{ $house->users->user_fname }}'s home is located in {{ $house->addresscities->city_name }} {{ $house->addressstates->state_name }}, {{ $house->addresscountries->country_name }} </p>
						@if ($house->about_neighborhood != NULL)
						<br>
						<p>{!! $house->about_neighborhood !!}</p>
						@endif
					</div>
					<div id="map-canvas"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<ul class="nav nav-tabs">
	    		<li class="active" ><a data-toggle="tab" href="#menu1">Details</a></li>
	    		<li class=""><a data-toggle="tab" href="#menu2">Reviews</a></li>
	  		</ul>

	  		<div class="tab-content">
	    		<div id="menu1" class="tab-pane fade in active">
	    			<p class="margin-top-10"><img src="https://www.shareicon.net/data/128x128/2015/10/29/663979_users_512x512.png" style="width: 15px; margin-bottom: 5px;"> {{ $house->house_capacity }} guests 
						<img src="https://www.shareicon.net/data/128x128/2016/07/11/598206_home_64x64.png" style="width: 15px; margin-bottom: 5px;"> {{ $house->house_bedrooms }} bedroom 
						<img src="https://www.shareicon.net/data/128x128/2015/12/21/691012_sleep_512x512.png" style="width: 15px; margin-bottom: 5px;"> {{ $house->house_beds}} bed 
						<img src="https://www.shareicon.net/data/128x128/2016/02/24/724310_tool_512x512.png" style="width: 15px; margin-bottom: 5px;"> {{ $house->house_bathroom }} bathroom
					</p>
					<h4>About place</h4>
					<div class="margin-top-10">
						<div class="card">
							<div class="margin-content">
								@if ( $house->about_your_place != NULL)
									{!! $house->house_description !!}
									<br>
									{!! $house->about_your_place !!}
									<br>
								@endif
								@if ($house->guest_can_access != NULL)
									<h5>Guest access</h5>
									{!! $house->guest_can_access !!}
									<br>
								@endif
								@if ($house->optional_note != NULL)
									<h5>Optional Note</h5>
									{!! $house->optional_note !!}
									<br>
								@endif
							</div>
						</div>
					</div>

					<h4>Cancellations</h4>
					<div class="margin-top-10">
						<div class="card">
							<div class="margin-content">
								<p>Free cancellation</p>
								<p>Cancel within {{ ($house->guestarrives->notice) }} of booking to get a full refund.</p>
							</div>
						</div>
					</div>

					<h4>Amenities</h4>
					<div class="margin-top-10">
						<div class="card">
							<div class="margin-content">
								<ul>
									@foreach ($house->houseamenities as $houseamenity)
									<li>{{ $houseamenity->amenityname }}</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>

					<h4>House Rules</h4>
					<div class="margin-top-10">
						<div class="card">
							<div class="margin-content">
								<ul>
									@foreach ($house->houserules as $houserule)
									<li>{{ $houserule->houserule_name }}</li>
									@endforeach
									
									<hr>
									<p>You must also acknowledge</p>
									@foreach ($house->housedetails as $housedetail)
									<li>{{ $housedetail->must_know }}</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
					
					<h4>Safety features</h4>
					<div class="margin-top-10">
						<div class="card">
							<div class="margin-content">
								<ul>
									<li>Smoke detector</li>
									<li>First aid kit</li>
									<li>Fire extinguisher</li>
								</ul>
							</div>
						</div>
					</div>
	    		</div>
	    		<div id="menu2" class="tab-pane fade">
	    			<h2>Reviews</h2>
					<h4>User Reviews</h4>
					@if ($house->reviews()->count() != 0)
					<h3 class="comment-title"><i class="far fa-star"></i> Average {{ $avg }} <small>Base on {{ $house->reviews()->count() }} Reviews</small></h3>
					@elseif ($house->reviews()->count() == 0)
					<h3 class="comment-title"><i class="far fa-star"></i> No Review</h3>
					@endif

					@foreach ($house->reviews as $review)
					<div class="card">
						<div class="margin-content">
							<div class="comment">
								<div class="author-info">
									<img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($review->user->email))) . '?s=50&d=monsterid' }}" class="author-image">
									<div class="author-name">
										<h4>{{ $review->user->user_fname }} @if ($review->user->user_verifications->verify == '1') <small style="color: green;"><i class="far fa-check-circle"></i></small> @endif</h4>
										<p class="author-time">{{ date('jS F, Y - g:iA', strtotime($review->created_at)) }}</p>
									</div>
								</div>
								<div class="comment-content">
									<p>{!! $review->comment !!}</p>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					<a href="#" class="btn btn-info btn-sm form-spacing-top-8">Read more reviews</a>
	    		</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	<script type="text/javascript">
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
			
		});

		$(document).ready(function(){
      		var datein=$('input[name="datein"]'); //our date input has the name "date"
      		var dateout=$('input[name="dateout"]'); //our date input has the name "date"
      		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      		var options={
	        	format: 'yyyy-mm-dd',
	        	container: container,
	        	todayHighlight: true,
	        	autoclose: true,
	      	};
	      	datein.datepicker(options);
	      	dateout.datepicker(options);
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
            fillOpacity: 1,
            map: map,
            center: {lat: lat, lng: lng},
            radius: Math.sqrt(10) * 60
		});
	</script>
@endsection