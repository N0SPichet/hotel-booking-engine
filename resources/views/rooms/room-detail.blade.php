@extends ('main')

@section ('title', 'Room Detail')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="w3-content w3-display-container">
				@foreach ($images as $image)
  				<img class="mySlides" src="{{ asset('images/houses/' . $image->image_name) }}" style="width:100%">
  				@endforeach

  				<button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
  				<button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
			</div>
		</div>
	</div> <!-- end of header row-->

	<div class="row">
		<div class="col-md-7">
			<h2>{{ $house->house_title }}</h2>
			<p>{{ $house->house_guestspace }}</p>

			<br>
			<p><img src="https://www.shareicon.net/data/128x128/2015/10/29/663979_users_512x512.png" style="width: 15px; margin-bottom: 5px;"> {{ $house->house_capacity }} guests 
				<img src="https://www.shareicon.net/data/128x128/2016/07/11/598206_home_64x64.png" style="width: 15px; margin-bottom: 5px;"> {{ $house->house_bedrooms }} bedroom 
				<img src="https://www.shareicon.net/data/128x128/2015/12/21/691012_sleep_512x512.png" style="width: 15px; margin-bottom: 5px;"> {{ $house->house_beds}} bed 
				<img src="https://www.shareicon.net/data/128x128/2016/02/24/724310_tool_512x512.png" style="width: 15px; margin-bottom: 5px;"> {{ $house->house_bathroom }} bathroom</p>

			<h4>Amenities</h4>
			<div class="well">
				<ul>
					@foreach ($house->houseitems as $houseitem)
					<li>{{ $houseitem->houseitem_name }}</li>
					@endforeach
				</ul>
			</div>

			<hr>
			<h4>Prices</h4>
			<div class="well">
				<ul>
					<li>Cleaning Fee ฿400</li>
					<li>Security Deposit ฿2000</li>
					<li>Weekly Discount: 6%</li>
					<li>Monthly Discount: 25%</li>
					<li>Weekend Price ฿{{ ($house->house_price)*1.2 }}/ night</li>
				</ul>
			</div>

			<hr>
			<h4>House Rules</h4>
			<div class="well">
				<ul>
					@foreach ($house->houserules as $houserule)
					<li>{{ $houserule->houserule_name }}</li>
					@endforeach
					
					<hr>

					<li>No parties, events, photo shoots or film shoots are allowed without express advance permission from home owner- additional fees and supervision required. Rental of the Off-grid it house is for vacation purposes only, personal photos are allowed. Additional rental terms and fees apply to rent the house for commercial photo shoots or events. Please contact us through airbnb if you wish to rent the house for an event or a photoshoot for additional details.</li>
				</ul>
			</div>

			<hr>
			<h4>Safety features</h4>
			<div class="well">
				<ul>
					<li>Smoke detector</li>
					<li>First aid kit</li>
					<li>Fire extinguisher</li>
				</ul>
			</div>

			<br>
			<h2>Hosted by {{ $house->users->user_fname }} {{ $house->users->user_lname }}</h2>
			<p>{{ $house->users->user_description }}</p>
			<div>
				<button class="btn btn-info btn-sm">Contact Host</button>
			</div>
			
			<br>
			<h2>Location</h2>
			<p>{{ $house->users->user_fname }}'s home is located in {{ $house->addresscities->city_name }} {{ $house->addressstates->state_name }}, {{ $house->addresscountries->country_name }} </p>
			<br>
			<div class="text-center">
				<iframe
			  	width="100%"
			  	height="450"
			  	frameborder="0" style="border:0"
			  	src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAtwyEAd3qWoPNnmIr6YyjaQmn_5LQtv0w
			    	&q={{ $house->addresscities->city_name }} + {{ $house->addressstates->state_name }}" allowfullscreen>
			</iframe>
			</div>
		</div>

		<div class="col-md-3 col-md-offset-1">
			<div class="row">
				<div class="col-md-12">
					<br>
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
						{{ Form::submit('Request to Book', array('class' => 'btn btn-success btn-lg btn-h1-spacing')) }}
					</div>

				{!! Form::close() !!}
			</div>
		</div>
	</div> <!-- end of detail row-->
</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		var slideIndex = 1;
		showDivs(slideIndex);

		function plusDivs(n) {
  			showDivs(slideIndex += n);
		}

		function showDivs(n) {
  			var i;
  			var x = document.getElementsByClassName("mySlides");
  			if (n > x.length) {slideIndex = 1}    
  			if (n < 1) {slideIndex = x.length}
  			for (i = 0; i < x.length; i++) {
     			x[i].style.display = "none";  
  			}
  			x[slideIndex-1].style.display = "block";  
		}
	</script>
@endsection