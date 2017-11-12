@extends ('main')

@section ('title', 'Room Detail | Agreement')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container">

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Review house rules</h1>
				<div>
					<ul>
						@foreach ($house->houserules as $houserule)
							<li>{{ $houserule->houserule_name }}</li>
						@endforeach
						
						<hr>
						<p>You must also acknowledge</p>
						@foreach ($house->housedetails as $housedetail)
							<li>{{ $housedetail->must_know }}</li>
						@endforeach
						@if ($house->optional_rules != NULL)
						<hr>
						<p>Additional rules</p>
						<p>{{ $house->optional_rules }}</p>
						@endif
					</ul>
				</div>
				<hr>

				{!! Form::open(array('route' => 'rentals.store', 'data-parsley-validate' => '')) !!}

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