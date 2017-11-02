@extends('main')

@section('title','Contact Us')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Contact Us</h1>
			<hr>

			<form action="{{ route('postcontact') }}" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<label name="email">Email</label>
					<input type="email" name="email" class="form-control">
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