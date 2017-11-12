@extends('main')

@section('title','Contact Us')

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
				<center><h3>Contact Us</h3></center>
				<div class="col-md-6">
					<br>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.248948846275!2d98.37821901477865!3d7.868997594330614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30502e1bfc957965%3A0x28fc8e8cfd73ff42!2sThe+Wide+Condotel!5e0!3m2!1sth!2sth!4v1492435787446" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<div class="col-md-6">
					<br>
					<form role="form" action="sendMessage" method="post" >
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<label>Your Name</label>
						<input placeholder="Enter name" type="text" class="form-control" name="cont_name" id="cont_name" required>
						<label>Your Email</label>
						<input placeholder="Enter email" type="email" class="form-control" id="cont_email" name="cont_email" required  >
						<label>Message</label>
						<textarea name="cont_message" id="cont_message" class="form-control" rows="3" required></textarea>
						<input type="submit" name="submit" id="submit" value="Send">
					</form>
					<address >
						<h3>Office Location</h3>
						<b>THE WIDE CONDOTEL PHUKET</b><br>
						13/10 Sakdidej Rd., Talad Nua ,Muang , <br>Phuket 83000 , Thailand<br>
						<b>Phone: </b>+6699 909 5414, +6699 909 5441 , +6676 681 261-2<br>
						<b>Fax: </b>+6676 355 707<br>
						<b>Email: </b>info@thewidecondotel.com<br>
					</address>
				</div>
		</div>
	</div>
</div>
@endsection