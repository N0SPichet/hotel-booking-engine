@extends('main')

@section('title',"Contact Host")

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Contact {{ $house->users->user_fname }}</h1>
			<hr>
		</div>
		<div class="col-md-6">
			<h4>Once you send a message, {{ $house->users->user_fname }} can invite you to book their home.</h4>
			<p>Make sure you share the following:</p>
			<ul>
				<li>Tell {{ $house->users->user_fname }} a little about yourself</li>
				<li>What brings you to {{ $house->addresscities->city_name }}? Who’s joining you?</li>
				<li>What do you love about this room? Mention it!</li>
			</ul>
		</div>
			
		<div class="col-md-6">
			<form action="{{ route('postcontacthost') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="receiveremail" value="{{ $house->users->email }}">
				<input type="hidden" name="id" value="{{ $house->id }}">
				<div class="form-group">
					<label name="senderemail">Your email</label>
					<input type="email" name="senderemail" class="form-control">
				</div>

				<div class="form-group">
					<label name="subject">Subject</label>
					<input type="text" name="subject" class="form-control">
				</div>

				<div class="form-group">
					<label name="message">Message</label>
					<textarea name="message" class="form-control"></textarea>
				</div>

				<input type="submit" value="Sent Message" class="btn btn-success">
			</form>
		</div>
	</div>
</div>
@endsection