@extends ('main')
@section ('title', $rental->houses->province->name .' Trip')
@section('stylesheets')
	<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=qei14aeigd6p0lkquybi330fte0vp7ne9ullaou6d5ti437y"></script>
  	<script>
  		tinymce.init({ 
  			selector:'textarea',
  			menubar: false
  		});
  	</script>
@endsection

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-12">
			<p class="lead">Rental #ID {{ $rental->id }}</p>
		</div>
		<div class="col-md-8">
			<div class="card">
				<div class="margin-content">
					<label>Booking Detail</label>
					<p>@if($types == 'apartment') <img src="{{ asset('images/houses/apartment.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> @else <img src="{{ asset('images/houses/house.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> @endif Room Name :  {{ $rental->houses->house_title }}  </p>
						
					<p><i class="fas fa-user"></i> Hosted by : {{ $rental->houses->users->user_fname }} {{ $rental->houses->users->user_lname }}</p>
						
					<p><i class="fas fa-user"></i> Rented by : <a href="{{ route('users.show', $rental->user_id) }}" target="_blank" class="btn btn-outline-info">{{ $rental->user->user_fname }} {{ $rental->user->user_lname }}</a></p>
						
					<p><i class="far fa-calendar-alt"></i> Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} ({{$days}} {{$days > 1 ? 'nights' : 'nignt'}}) </p>
					@if ($types == 'apartment')
						@if ($rental->no_type_single > 0)
						<p><i class="fas fa-bed"></i> Single Room (Standard) : {{ $rental->no_type_single }} {{ $rental->no_type_single > 1 ? 'Rooms':'Room' }}.</p>
						@endif
						@if ($rental->no_type_deluxe_single > 0)
						<p><i class="fas fa-bed"></i> Deluxe Single Room : {{ $rental->no_type_deluxe_single }} {{ $rental->no_type_deluxe_single > 1 ? 'Rooms':'Room' }}.</p>
						@endif
						@if ($rental->no_type_double_room > 0 )
						<p><i class="fas fa-bed"></i> Double Room (Standard) : {{ $rental->no_type_double_room }} {{ $rental->no_type_double_room > 1 ? 'Rooms':'Room' }}.</p>
						@endif
					@else
					<p><i class="far fa-user"></i> Total guest : {{ $rental->rental_guest }} guest</p>
					<p><i class="fas fa-bed"></i> Room number : {{ $rental->no_rooms }}</p>
					@endif
					@if ($rental->inc_food == '1')<p><i class="fas fa-utensils"></i> Food included</p> @elseif ($rental->inc_food == '0')<p> <i class="fas fa-utensils"></i> Food are not included</p> @endif
					@if ($rental->payment->payment_status == 'Approved')
					<p>Address : {{ $rental->houses->house_address }} {{ $rental->houses->sub_district->name }} {{ $rental->houses->district->name }}, {{ $rental->houses->province->name }}</p>
					<div id="map-canvas"></div>
					@endif
					<br>

					@if ($rental->host_decision == 'ACCEPT')
					<p class="text-primary"><b>Host Accepted.</b></p>
					@endif

					@if ( Auth::user()->id == $rental->user->id && $rental->payment->payment_status == 'Approved' )
					<p>Check in Code : <strong>{{ $rental->checkincode }}</strong></p>
					<p class="margin-content">use this code to self check in</p>
					@endif
						
					@if ( $rental->checkin_status == '1' )
					<p>Check in Status: <button class="btn-success">Confirmed</button></p>
					@elseif ($rental->checkin_status == '0')
					<p>Check in  Status: <span class="text-danger">NO</span></p>
					@endif
				</div>
			</div>
			
			@if($rental->payment->payment_status != null)
			<div class="m-t-20">
				<div class="card">
					@if($rental->payment->payment_status != 'Cancel')
					<div class="margin-content">
						@if($rental->payment->payment_status == 'Waiting')
						@if(Auth::user()->hasRole('Admin'))
						<b>Admin Section : click on waiting status if this payment is <span class="text-success">pass</span>.</b>
						{!! Form::open(['route' => ['rentals.approve', $rental->id], 'method' => 'POST']) !!}
							<button type="submit" class="btn btn-primary btn-sm" style="width: 120px;">
							<div class="text-white">
								<div class="text-center"><i class="far fa-check-circle"></i> {{ $rental->payment->payment_status }}</div>
							</div>
							</button>
						{!! Form::close() !!}
						@endif
						@endif
					</div>
					<div class="margin-content">
						<label>Payment</label>
						@if ($rental->payment->payment_status != 'Out of Date')
						<p> Bank Name : {{ $rental->payment->payment_bankname }} </p>
						<p> Bank Holder : {{ $rental->payment->payment_holder }} </p>
						<p> Bank Account : {{ $rental->payment->payment_bankaccount }} </p>
						<p> Amount : {{ $rental->payment->payment_amount }} Thai Baht</p>
						@endif
						<p> Status : <b>{{ $rental->payment->payment_status }}</b> </p>
						@if ($rental->payment->payment_status == 'Cancel')
						<a href="#" class="btn btn-md btn-info">Refund</a>
						@endif

						@if ($rental->payment->payment_status != 'Out of Date')
						<div align="center">
							@if ($rental->payment->payment_transfer_slip != null)
							<a target="_blank" href="{{ asset('images/payments/'.$rental->payment_id.'/'.$rental->payment->payment_transfer_slip) }}"><img src="{{ asset('images/payments/'.$rental->payment_id.'/'.$rental->payment->payment_transfer_slip) }}" class="img-thumbnail" width="80" height="auto"></a>
							@else
							<img src="{{ asset('images/payments/default.png') }}" class="img-thumbnail" width="80" height="auto">
							@endif
						</div>
						<br>
						<p class="text-center">Transfer Slip</p>
						@endif
					</div>
					@else
					@if ($rental->payment->payment_status == 'Cancel')
					<div class="margin-content">
						<a href="#" class="btn btn-md btn-warning" style="width: 100px;">Refund</a>
					</div>
					@endif
					@endif
				</div>
			</div>
			@elseif ($rental->host_decision != null && $rental->host_decision != 'REJECT')
			<div class="m-t-20">
				<div class="card">
					<div class="margin-content">
						<label>{{ $rental->user->user_fname }} Not Paying Yet</label>
						@if (Auth::user()->id == $rental->user->id)
						<div>
							@if ($rental->host_decision == 'ACCEPT')
								@if ($rental->payment->payment_status == null)
								{!! Html::linkRoute('rentals.edit', 'Payment', array($rental->id), array('class' => 'btn btn-success btn-sm form-spacing-top-8 m-b-20')) !!}
								@else
								<button type="button" class="btn btn-success btn-sm form-spacing-top-8 m-b-20 disabled">
									<div class="text-center">Payment already submited</div>
								</button>
								@endif
								<p>{{ $rental->user->user_fname }} must have a payment in time and exactly as payment page show.</p>
								<p><b>Total price</b> <span class="text-danger">{{$total_price}}</span> Thai Bath!</p>
								@if ($types == 'apartment')
								<p>Details</p>
									@if ($rental->no_type_single > 0)
									<p><i class="fas fa-bed"></i> Single Room (Standard) : {{ $rental->no_type_single }} {{ $rental->no_type_single > 1 ? 'Rooms':'Room' }} - {{ $type_single_price }} Thai Bath.</p>
									@endif
									
									@if ($rental->no_type_deluxe_single > 0)
									<p><i class="fas fa-bed"></i> Deluxe Single Room : {{ $rental->no_type_deluxe_single }} {{ $rental->no_type_deluxe_single > 1 ? 'Rooms':'Room' }} - {{ $type_deluxe_single_price }} Thai Bath.</p>
									@endif

									@if ($rental->no_type_double_room > 0 )
									<p><i class="fas fa-bed"></i> Double Room (Standard) : {{ $rental->no_type_double_room }} {{ $rental->no_type_double_room > 1 ? 'Rooms':'Room' }} - {{ $type_double_room_price }} Thai Bath.</p>
									@endif
									<p>Service fee {{ $fee}} Thai Bath.</p>
								@endif
							@endif
						</div>
						@endif
					</div>
				</div>
			</div>
			@endif

			@if ($rental->host_decision == 'ACCEPT' && $rental->checkin_status == '1')
				@if ($rental->payment->payment_status != 'Out of Date' && $rental->payment->payment_status != 'Cancel' && $rental->payment->payment_status != 'Reject')
				<div class="m-t-20">
					<div class="card">
						<div class="margin-content">
							@if ($review != null )
								@if ($rental->user_id == Auth::user()->id || $rental->houses->users->id == Auth::user()->id || Auth::user()->level == '0')
								<label>Review</label>
								<div class="comment">
									<div class="author-info">
										<img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($review->user->email))) . '?s=50&d=monsterid' }}" class="author-image">
										<div class="author-name">
											<h4>{{ $review->user->user_fname }} 
												@if (Auth::user()->id == $rental->user->id)
												<a href="{{ route('reviews.edit', $review->id)}}" style="position:absolute; bottom: 260px; right: 20px;" class="btn btn-default btn-sm"><i class="far fa-edit"></i></a>
												@endif
											</h4>
											<p class="author-time">{{ date('jS F, Y - g:iA', strtotime($review->created_at)) }}</p>
										</div>
									</div>
									<div class="comment-content">
										<p>cleaness : <span class="text-danger">{{ $review->clean }}</span></p>
										<p>amenities : <span class="text-danger">{{ $review->amenity }}</span></p>
										<p>services : <span class="text-danger">{{ $review->service }}</span></p>
										<p>host : <span class="text-danger">{{ $review->host }}</span></p>
										<p>{!! $review->comment !!}</p>
									</div>
								</div>
								@endif
							@endif

							@if ($review == null)
								@if ($rental->payment->payment_status == 'Approved' && $rental->checkin_status != '1')
									@if ($rental->user->id == Auth::user()->id)
									<p class="text-danger">Only Confirmed rental can review.</p>
									<p>To get Confirmed status : you must rent the room and have a completely check in.</p>
									@endif
								@endif

								@if ($rental->payment->payment_status == 'Approved' && $rental->checkin_status == '1')
									@if ( $rental->houses->users->id == Auth::user()->id )
									<label>Review</label>
									<p>No review</p>
									@elseif ( $rental->user->id == Auth::user()->id )
									<label>Write a Review</label>
									{!! Form::open(array('route' => 'reviews.store', 'data-parsley-validate' => '')) !!}
										<!-- <div class="col-md-6 col-sm-6"> -->
										{{ Form::hidden('house_id', $rental->houses->id) }}
										{{ Form::hidden('rental_id', $rental->id) }}

										{{ Form::label('name', 'Review as') }}
										{{ Form::text('name', Auth::user()->user_fname . " " . Auth::user()->user_lname, ['class' => 'form-control', 'required' => '', 'readonly' => '']) }}
										<!-- </div> -->
										{{ Form::label('clean', 'Clean') }}
										<div class="star-rating" align="center">
											@for ($i = 5; $i > 0; $i--)
											<input type="radio" name="clean" value="{{$i}}" id="clean-{{$i}}">
											<label for="clean-{{$i}}" title="star {{$i}}">
												<i class="far fa-star"></i>
											</label>
										@endfor
										</div>

										{{ Form::label('amenity', 'Amenity') }}
										<div class="star-rating" align="center">
										@for ($i = 5; $i > 0; $i--)
											<input type="radio" name="amenity" value="{{$i}}" id="amenity-{{$i}}">
											<label for="amenity-{{$i}}" title="star {{$i}}">
												<i class="far fa-star"></i>
											</label>
										@endfor
										</div>

										{{ Form::label('service', 'Service') }}
										<div class="star-rating" align="center">
										@for ($i = 5; $i > 0; $i--)
											<input type="radio" name="service" value="{{$i}}" id="service-{{$i}}">
											<label for="service-{{$i}}" title="star {{$i}}">
												<i class="far fa-star"></i>
											</label>
										@endfor
										</div>

										{{ Form::label('host', 'Host') }}
										<div class="star-rating" align="center">
										@for ($i = 5; $i > 0; $i--)
											<input type="radio" name="host" value="{{$i}}" id="host-{{$i}}">
											<label for="host-{{$i}}" title="star {{$i}}">
												<i class="far fa-star"></i>
											</label>
										@endfor
										</div>

										{{ Form::label('comment', 'Review') }}
										{{ Form::textarea('comment', null, ['class' => 'form-control', 'style' => 'margin-bottom: 10px;', 'rows' => '5']) }}
										{{ Form::submit('Publish', array('class' => 'btn btn-success btn-md m-t-10 pull-right')) }}
									{!! Form::close() !!}
									@endif
								@endif

							@endif
						</div>
					</div>
				</div>
				@endif
			@endif		
		</div>

		<div class="col-md-4">
			<div class="well">
				<div class="dl-horizontal">
					<label>Rented by:</label>
					<p> {{ $rental->user->user_fname }} {{ $rental->user->user_lname }} </p>
					<label>Created at:</label>
					<p> {{ date('M j, Y', strtotime($rental->created_at)) }} </p>
					<label>Last update:</label>
					<p> {{ date('M j, Y', strtotime($rental->updated_at)) }} </p>
				</div>

				<hr>
				@if (Auth::user()->id == $rental->houses->users_id)
				<div class="row">
					<div class="col-sm-4 float-left">
						<a href="{{ route('rentals.rentmyrooms', $rental->houses->users_id) }}" class="btn btn btn-link btn-md"><i class="fas fa-chevron-left"></i>Back</a>
					</div>
					<div class="col-sm-8 float-left">
						@if ($rental->host_decision != 'ACCEPT' && $rental->host_decision != 'REJECT'  && $rental->payment->payment_status != 'Cancel')
						{!! Form::open(['route' => ['rentals.accept-rentalrequest', $rental->id]]) !!}
							<button type="submit" class="btn btn-primary btn-block btn-sm"><i class="far fa-check-circle"></i> Accept</button>
						{!! Form::close() !!}

						{!! Form::open(['route' => ['rentals.reject-rentalrequest', $rental->id]]) !!}
							<button type="submit" class="btn btn-danger btn-block btn-sm form-spacing-top-8"><i class="far fa-times-circle"></i> Reject</button>
						{!! Form::close() !!}
						@elseif ($rental->host_decision == 'ACCEPT' && $rental->payment->payment_status != 'Cancel')
							<button class="btn btn-default btn-success btn-block btn-sm disabled"><i class="fas fa-check"></i> Accepted</button>
						@elseif ($rental->host_decision == 'REJECT' && $rental->payment->payment_status != 'Cancel')
							<button class="btn btn-default btn-danger btn-block btn-sm disabled"><i class="fas fa-check"></i> Rejected</button>
						@endif
					</div>
				</div>
				@endif
			</div>
			@if (Auth::user()->id == $rental->user->id)
			<div class="card">
				<div class="margin-content" align="center">
					@if ($rental->checkin_status == '1')
					<a href="{{ route('diaries.tripdiary', [$rental->id, $rental->user_id]) }}" class="btn btn-primary btn-md">Write Diary for this great trip</a>
					@else
					<p>To write diary for this great trip, you must have <span class="text-success">Confirmed</span> status.</p>
					@endif
				</div>
			</div>
			@endif
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

		var marker = new google.maps.Marker({
			position:{
				lat: lat,
				lng: lng
			},
			map: map,
			draggable: true
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