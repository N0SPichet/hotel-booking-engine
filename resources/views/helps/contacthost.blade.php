@extends('main')

@section('title',"Contact Host")

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
@endsection

@section('content')

<div class="container">
	<div class="row m-t-10">
		<div class="col-md-12">
			<h1 class="title-page">Contact {{ $house->user->user_fname }}</h1>
			<hr>
		</div>
		<div class="col-md-6 float-left">
			<h4>Once you send a message, {{ $house->user->user_fname }} can invite you to book their home.</h4>
			<p>Make sure you share the following:</p>
			<ul>
				<li>Tell {{ $house->user->user_fname }} about yourself</li>
				<li>What brings you to {{ $house->sub_district->name }}? Who’s joining you?</li>
			</ul>
		</div>
			
		<div class="col-md-6 float-left">
			<form action="{{ route('helps.postcontacthost') }}" data-parsley-validate method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="houseId" value="{{ $house->id }}">
				<input type="hidden" name="hostname" value="{{ $house->user->user_fname }}">
				<input type="hidden" name="receiveremail" value="{{ $house->user->email }}">
				<div class="form-group">
					<label>When you are coming?</label>
					<div class="col-md-12">
						<div class="col-md-6">
							<label for="checkin">Check In</label>
							<input type="text" name="checkin" class="form-control" required="" id = "checkin">
						</div>
						<div class="col-md-6">
							<label for="checkout">Check Out</label>
							<input type="text" name="checkout" class="form-control" required=""  id = "checkout">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="guest">Guests</label>
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
				<div class="form-group">
					<label for="message">Message</label>
					<textarea id="message" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Message should have have length 20 alphabets." class="form-control" required="" rows="5"></textarea>
				</div>
				<input type="submit" value="Sent Message" class="btn btn-success">
			</form>
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
<script type="text/javascript">
	$(document).ready(function(){
  		var checkin=$('input[name="checkin"]'); //our date input has the name "date"
  		var checkout=$('input[name="checkout"]'); //our date input has the name "date"
  		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
  		var options={
	    	format: 'yyyy-mm-dd',
	    	container: container,
	    	todayHighlight: true,
	    	autoclose: true,
	  	};
	  	checkin.datepicker(options);
	  	checkout.datepicker(options);
	});
</script>
@endsection
