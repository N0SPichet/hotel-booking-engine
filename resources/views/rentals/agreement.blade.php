@extends ('main')

@section ('title', 'Room Detail | Agreement')

@section ('content')
<div class="container">

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>House Rules</h1>
				<div>
					<ul>
						@foreach ($house->houserules as $houserule)
							<li>{{ $houserule->houserule_name }}</li>
						@endforeach
						
						<hr>

						<li>No parties, events, photo shoots or film shoots are allowed without express advance permission from home owner- additional fees and supervision required. Rental of the Off-grid it house is for vacation purposes only, personal photos are allowed. Additional rental terms and fees apply to rent the house for commercial photo shoots or events. Please contact us through airbnb if you wish to rent the house for an event or a photoshoot for additional details.</li>
					</ul>
				</div>
				<hr>

				{!! Form::open(array('route' => 'rentals.payment', 'data-parsley-validate' => '')) !!}

					<div class="form-check">
				    	<label class="form-check-label">
				        	<input type="radio" class="form-check-input" name="agreement" id="agreement" value="agree" required="">
				        	I agree with term & conditiions
				      	</label>
				    </div>

					{{ Form::hidden('id', $id, array()) }}
					{{ Form::hidden('datein', $datein, array()) }}
					{{ Form::hidden('dateout', $dateout, array()) }}
					{{ Form::hidden('guest', $guest, array()) }}

					<hr>

					{{ Form::submit('Agree and continue', array('class' => 'btn btn-success btn-md btn-h1-spacing')) }}
				{!! Form::close() !!}
		</div>
	</div> <!-- end of detail row-->
</div>
@endsection