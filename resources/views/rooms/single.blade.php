@extends ('main')

@section ('title', 'Review your settings | Rooms')

@section ('content')
<div class="container">
	<div class="row">
			<div class="col-md-8">
				<h1>Review your settings</h1>
				<div class="col-md-12">
					
					<h4>Images</h4>

					@foreach ($images as $image)
					<div class="col-md-4">
						<img src="{{ asset('images/houses/' . $image->image_name) }}" class="img-responsive" style="width:100%;">
						<br>
					</div>
					@endforeach

				</div>
				<div class="col-md-12">
					<h4>Room</h4>
					<br>
					<p> Room Title : {{ $house->house_title }} </p>
					<p> Room Description : {{ $house->house_description }}</p>
					<p> Type of property : {{ $house->house_property }} </p>
					<p> Guests have : {{ $house->house_guestspace }} </p>

					<hr>
					<h4>Bedroom</h4>
					<br>
					<p> How many guests can your place accommodate : {{ $house->house_capacity }} guest </p>
					<p> How many bedrooms : {{ $house->house_bedrooms }} room </p>
					<p> How many beds : {{ $house->house_beds }} bed </p>

					<hr>
					<h4>Bathroom</h4>
					<br>
					<p> How many bathrooms : {{ $house->house_bathroom }} room </p>
					<p> Is the bathroom private :  
						@if ($house->house_bathroomprivate == 1)
							Yes
						@else if ($house->house_bathroomprivate != 1)
							No
						@endif
					</p>

					<hr>
					<h4>Address</h4>
					<br>
					<p> {{ $house->house_address }} {{ $house->addresscities->city_name }} {{ $house->addressstates->state_name }}, {{ $house->addresscountries->country_name }} </p>
					<p>Postcode {{ $house->house_postcode }} </p>
					
					<hr>
					<h4>Amenities</h4>
					<br>
					@foreach ($house->houseamenities as $houseamenity)
						<p>{{ $houseamenity->amenityname }}</p>
					@endforeach

					<hr>
					<h4>Shared space</h4>
					<br>
					@foreach ($house->housespaces as $housespace)
						<p>{{ $housespace->spacename }}</p>
					@endforeach

					<hr>
					<h4>Your House Rules</h4>
					<br>
					@foreach ($house->houserules as $houserule)
						<p>{{ $houserule->houserule_name }}</p>
					@endforeach

					<hr>
					<h4>Availability</h4>
					<br>
					<p>Advance notice: 2 days</p>
					<p>Booking window: Any time</p>
					@if ($house->guestarrives->checkin_to == 'Flexible')
					<p>Check-in: Anytime after {{ $house->guestarrives->checkin_from }}</p>
					@else
					<p>Check-in: {{ $house->guestarrives->checkin_from }} - {{ $house->guestarrives->checkin_to }}</p>
					@endif

					<hr>
					<h4>Pricing</h4>
					<br>
					<p>Base price: ฿{{ $house->houseprices->price }}/night</p>
					<p>Weekly discount: {{ $house->houseprices->weekly_discount }}%</p>
					<p>Monthly discount: {{ $house->houseprices->monthly_discount }}%</p>

				</div>
			</div>

			<div class="col-md-4">
				<div class="well">
					<div class="dl-horizontal">
						<label> Created by : </label>
						<p> {{ $house->users->user_fname }} {{ $house->users->user_lname }} </p>
						<label> Rent Count :</label>
						<p> {{ $rentcount }}</p>
						<label> Created at : </label>
						<p> {{ date("jS F, Y", strtotime($house->created_at)) }} </p>
						<label>Last Update : </label>
						<p> {{ date("jS F, Y", strtotime($house->updated_at)) }} </p>
					</div>
					@if ($house->users_id == Auth::user()->id)
					<div class="row">
						<div class="col-sm-6">
							{!! Html::linkRoute('rooms.edit', 'Edit', array($house->id), array('class' => 'btn btn-primary btn-block btn-h1-spacing')) !!}
						</div>
						<div class="col-sm-6">
							{!! Form::open(['route' => ['rooms.destroy', $house->id], 'method' => 'DELETE']) !!}

							{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block btn-h1-spacing']) !!}

							{!! Form::close() !!}
						</div>
					</div>
					@endif
					<hr>
					<div class="row">
						<div class="col-sm-6">
							{!! Html::linkRoute('rooms.index', 'Back to My Room', array(''), array('class' => 'btn btn btn-link btn-md')) !!}
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
@endsection