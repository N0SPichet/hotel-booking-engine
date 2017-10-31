@extends ('main')

@section ('title', $house->users->user_fname. ' | ' .'Rooms')

@section ('content')
<div class="container">
	<div class="row">
			<div class="col-md-8">
				<p class="lead">{{ $house->house_title }}</p>
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

					<br>
					<h4>Room</h4>
					<p> Room Title : {{ $house->house_title }} </p>
					<p> Room Description : {{ $house->house_description }}</p>
					<p> Type of property : {{ $house->house_property }} </p>
					<p> Guests have : {{ $house->house_guestspace }} </p>

					<br>
					<h4>Bedroom</h4>
					<p> How many guests can your place accommodate : {{ $house->house_capacity }} guest </p>
					<p> How many bedrooms : {{ $house->house_bedrooms }} room </p>
					<p> How many beds : {{ $house->house_beds }} bed </p>

					<br>
					<h4>Bathroom</h4>
					<p> How many bathrooms : {{ $house->house_bathroom }} room </p>
					<p> Is the bathroom private :  
						@if ($house->house_bathroomprivate == 1)
							Yes
						@else if ($house->house_bathroomprivate != 1)
							No
						@endif
					</p>
					
					<br>
					<h4>Amenities</h4>
					<ul>
						@foreach ($house->houseitems as $houseitem)
							<li>{{ $houseitem->houseitem_name }}</li>
						@endforeach
					</ul>

					<br>
					<h4>Rules</h4>
					<ul>
						@foreach ($house->houserules as $houserule)
							<li>{{ $houserule->houserule_name }}</li>
						@endforeach
					</ul>

					<br>
					<h4>Address</h4>
					<p> {{ $house->house_address }} {{ $house->addresscities->city_name }} {{ $house->addressstates->state_name }}, {{ $house->addresscountries->country_name }} </p>
					<p>Postcode {{ $house->house_postcode }} </p>

					<br>
					<h4>Pricing</h4>
					<p>Price : {{ $house->house_price }} THB/Night</p>

				</div>
			</div>

			<div class="col-md-4">
				<div class="well">
					<div class="dl-horizontal">
						<label> Created by : </label>
						<p> {{ $house->users->user_fname }} {{ $house->users->user_lname }} </p>
						<label> Created at : </label>
						<p> {{ date("jS F, Y", strtotime($house->created_at)) }} </p>
						<label>Last Update : </label>
						<p> {{ date("jS F, Y", strtotime($house->updated_at)) }} </p>
					</div>
					@if ($house->user_id == Auth::user()->id)
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
							{!! Html::linkRoute('rooms.index', 'Back to My house', array(''), array('class' => 'btn btn btn-link btn-md')) !!}
						</div>
					</div>
				</div>
			</div>
	</div> <!-- end of col-md-12 row-->
</div>
@endsection