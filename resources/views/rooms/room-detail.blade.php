@extends ('main')

@section ('title', 'Room Detail')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="jumbotron">
				<h4>แสดงรูปที่นี่</h4>
			</div>
		</div>
	</div> <!-- end of header row-->

	<div class="row">
		<div class="col-md-7">

			<h4>Amenities</h4>
			<div class="well">
				<ul>
					<li>Kitchen</li>
					<li>Indoor fireplace</li>
					<li>Wireless Internet</li>
					<li>Free parking on premises</li>
					<li>Essentials</li>
					<li>Heating</li>
					<li>Private entrance</li>
				</ul>
			</div>

			<h4>Prices</h4>
			<div class="well">
				<ul>
					<li>Cleaning Fee ฿400</li>
					<li>Security Deposit ฿2000</li>
					<li>Weekly Discount: 6%</li>
					<li>Monthly Discount: 25%</li>
					<li>Weekend Price ฿1000 / night</li>
				</ul>
			</div>

			<h4>House Rules</h4>
			<div class="well">
				<ul>
					<li>No smoking</li>
					<li>Not suitable for pets</li>
					<li>No parties or events</li>
					<li>Not safe or suitable for children (0-12 years)</li>
					<li>Check in is anytime after 2PM</li>
					<li>Check out by 10AM</li>
					
					<hr>

					<li>No parties, events, photo shoots or film shoots are allowed without express advance permission from home owner- additional fees and supervision required. Rental of the Off-grid it house is for vacation purposes only, personal photos are allowed. Additional rental terms and fees apply to rent the house for commercial photo shoots or events. Please contact us through airbnb if you wish to rent the house for an event or a photoshoot for additional details.</li>
				</ul>
			</div>

			<h4>Safety features</h4>
			<div class="well">
				<ul>
					<li>Smoke detector</li>
					<li>First aid kit</li>
					<li>Fire extinguisher</li>
				</ul>
			</div>

			<h4>Hosted by {{ $house->users->user_fname }} {{ $house->users->user_lname }}</h4>
			<div>
				<button class="btn btn-info btn-sm">Contact Host</button>
			</div>
			<p>{{ $house->users->user_fname }}'s home is located in {{ $house->addresscities->city_name }} {{ $house->addressstates->state_name }}, {{ $house->addresscountries->country_name }} </p>
		</div>

		<div class="col-md-3 col-md-offset-1">
			<div class="row">
				<div class="col-md-12">
					Room {{ $house->id }} : {{ $house->house_price }} THB/Night
				</div>
			
				<!-- <form method="post" action="/rentals/agreement">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<input type="hidden" name="id" value="{{ $house->id }}" class="form-control">
					
					<label>Check In:</label>
					<input type="date" name="datein" class="form-control" required>

					<label>Check Out:</label>
					<input type="date" name="dateout" class="form-control" required>

					<label>Guest</label>
					<select class="form-control" name="guest">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
					</select>

					<input type="submit" name="submit" class="btn btn-success btn-lg btn-h1-spacing" value="Book Now">
				</form> -->

				{!! Form::open(array('route' => 'rentals.agreement', 'data-parsley-validate' => '')) !!}

					{{ csrf_field() }}

					{{ Form::hidden('id', $house->id, array('class' => 'form-control input-lg')) }}

					<div class="col-sm-6 col-md-12">
						{{ Form::label('datein', 'Check In:') }}
						{{ Form::date('datein', null, array('class' => 'form-control', 'required' => '')) }}
					</div>

					<div class="col-sm-6 col-md-12">
						{{ Form::label('dateout', 'Check Out:') }}
					{{ Form::date('dateout', null, array('class' => 'form-control', 'required' => '')) }}
					</div>

					<div class="col-md-12">
						{{ Form::label('guest', 'Guest:') }}
						<select class="form-control" name="guest">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
					</div>

					<div class="text-center">
						{{ Form::submit('Book Now', array('class' => 'btn btn-success btn-lg btn-h1-spacing')) }}
					</div>

				{!! Form::close() !!}
			</div>
		</div>
	</div> <!-- end of detail row-->
</div>
@endsection