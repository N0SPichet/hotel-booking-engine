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
			<div>
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
			<hr>

			<h4>Prices</h4>
			<div>
				<ul>
					<li>Cleaning Fee ฿400</li>
					<li>Security Deposit ฿2000</li>
					<li>Weekly Discount: 6%</li>
					<li>Monthly Discount: 25%</li>
					<li>Weekend Price ฿1000 / night</li>
				</ul>
			</div>
			<hr>

			<h4>House Rules</h4>
			<div>
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
			<hr>

			<h4>Safety features</h4>
			<div>
				<ul>
					<li>Smoke detector</li>
					<li>First aid kit</li>
					<li>Fire extinguisher</li>
				</ul>
			</div>
			<hr>

			<h4>Hosted by {{ $house->users->user_fname }} {{ $house->users->user_lname }}</h4>
			<div>
				<button class="btn btn-info btn-sm">Contact Host</button>
			</div>
			<hr>
		</div>

		<div class="col-md-3 col-md-offset-1">
			Room {{ $house->house_name }} : {{ $house->house_price }} THB/Night
			{!! Form::open(array('route' => 'rentals.index', 'data-parsley-validate' => '')) !!}
				{{ Form::label('datein', 'Check In: ') }}
				{{ Form::date('datein', null, array('class' => 'form-control', 'required' => '')) }}
				
				{{ Form::label('dateout', 'Check Out: ') }}
				{{ Form::date('dateout', null, array('class' => 'form-control', 'required' => '')) }}

				{{ Form::label('guest', 'Guest') }}
				{{ Form::text('guest', null, array('class' => 'form-control', 'required' => '')) }}
				
				{{ Form::submit('Book Now', array('class' => 'btn btn-success btn-lg')) }}
			{!! Form::close() !!}
		</div>
	</div> <!-- end of detail row-->
</div>
@endsection