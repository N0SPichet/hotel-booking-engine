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
							<li>{{ $houserule->name }}</li>
						@endforeach
						
						<hr>
						<p>You must also acknowledge</p>
						@foreach ($house->housedetails as $housedetail)
							<li>{{ $housedetail->name }}</li>
						@endforeach
						@if ($house->optional_rules != NULL)
						<hr>
						<p>Additional rules</p>
						<div class="bg-warning">
							<p>{{ $house->optional_rules }}</p>
						</div>
						@endif
					</ul>
				</div>
				<hr>

				{!! Form::open(array('route' => 'rentals.store', 'data-parsley-validate' => '')) !!}

					<div class="form-check">
				    	<label class="form-check-label">
				        	<input type="radio" class="form-check-input" name="agreement" id="agreement" value="agree" required="" style="margin-left: -20px;">
				        	I agree with term & conditiions
				      	</label>
				    </div>

					{{ Form::hidden('id', $id, []) }}
					{{ Form::hidden('datein', $datein, []) }}
					{{ Form::hidden('dateout', $dateout, []) }}
					{{ Form::hidden('types', $types, []) }}

					@if ($types == 'room')
					{{ Form::hidden('guest', $guest, []) }}
					{{ Form::hidden('no_rooms', $no_rooms, []) }}
					{{ Form::hidden('food', $food, []) }}
					@else
					{{ Form::hidden('no_type_single', $no_type_single, []) }}
					{{ Form::hidden('no_type_deluxe_single', $no_type_deluxe_single, []) }}
					{{ Form::hidden('no_type_double_room', $no_type_double_room, []) }}
					{{ Form::hidden('type_single_price', $type_single_price, []) }}
					{{ Form::hidden('type_deluxe_single_price', $type_deluxe_single_price, []) }}
					{{ Form::hidden('type_double_room_price', $type_double_room_price, []) }}
					@endif

					<hr>

					{{ Form::submit('Agree and continue', array('class' => 'btn btn-success btn-md btn-h1-spacing')) }}
				{!! Form::close() !!}
		</div>
	</div> <!-- end of detail row-->
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
@endsection
