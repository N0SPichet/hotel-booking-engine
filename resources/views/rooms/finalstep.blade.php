@extends ('main')

@section ('title', 'Final Step | Hosting')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
	{!! Html::style('css/select2.min.css') !!}
@endsection

@section ('content')
<div class="container">
	<div class="row">
			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

			{!! Form::open(array('route' => 'rooms.store', 'data-parsley-validate' => '','files' => true )) !!}
				<div class="col-md-12 col-md-offset-0">
					<h2>House rules</h2>
					<hr>
				</div>
				<div class="col-md-6 col-md-offset-3">
					{{ Form::label('houserules', 'Set your house rules', ['class' => 'form-spacing-top-8']) }}
					<select class="form-control select2-multi form-spacing-top-8" name="houserules[]" multiple="multiple">
						@foreach ($houserules as $houserule)
							<option value="{{ $houserule->id }}">{{ $houserule->houserule_name }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-6 col-md-offset-3">
					{{ Form::label('housedetails', 'Details guests must know about your home', ['class' => 'form-spacing-top-8']) }}
					@foreach ($housedetails as $housedetail)
					<p>
						{{ Form::checkbox('housedetails[]', $housedetail->id, null, ['class' => 'field', 'multiple' => 'multiple']) }}
						{{ Form::label('housedetails', $housedetail->must_know) }}
					</p>
					@endforeach
				</div>

				<div class="col-md-12 col-md-offset-0">
					<h2>Availability</h2>
					<hr>
				</div>
				<dir class="col-md-6 col-md-offset-3">
					{{ Form::label('notice', 'How much notice do you need before a guest arrives?') }}
					<select class="form-control form-spacing-top-8" name="notice">
						<option value="Same Day">Same Day</option>
						<option value="1">1 Day</option>
						<option value="2">2 Days</option>
						<option value="3">3 Days</option>
						<option value="7">7 Days</option>
					</select>

					<p><b>When can guests check in?</b></p>
					<div class="col-md-6">
						{{ Form::label('checkin_from', 'From:') }}
						<select class="form-control form-spacing-top-8" name="checkin_from">
							<option value="Flexible">Flexible</option>
							<option value="8AM">8AM</option>
							<option value="9AM">9AM</option>
							<option value="10AM">10AM</option>
							<option value="11AM">11AM</option>
							<option value="12PM (noon)">12PM (noon)</option>
							<option value="1PM">1PM</option>
							<option value="2PM">2PM</option>
							<option value="3PM">3PM</option>
							<option value="4PM">4PM</option>
							<option value="5PM">5PM</option>
							<option value="6PM">6PM</option>
							<option value="7PM">7PM</option>
							<option value="8PM">8PM</option>
							<option value="9PM">9PM</option>
							<option value="10PM">10PM</option>
							<option value="11PM">11PM</option>
							<option value="12AM (midnight)">12AM (midnight)</option>
						</select>
					</div>
					<div class="col-md-6">
						{{ Form::label('checkin_to', 'To:') }}
						<select class="form-control form-spacing-top-8" name="checkin_to">
							<option value="Flexible">Flexible</option>
							<option value="9AM">9AM</option>
							<option value="10AM">10AM</option>
							<option value="11AM">11AM</option>
							<option value="12PM (noon)">12PM (noon)</option>
							<option value="1PM">1PM</option>
							<option value="2PM">2PM</option>
							<option value="3PM">3PM</option>
							<option value="4PM">4PM</option>
							<option value="5PM">5PM</option>
							<option value="6PM">6PM</option>
							<option value="7PM">7PM</option>
							<option value="8PM">8PM</option>
							<option value="9PM">9PM</option>
							<option value="10PM">10PM</option>
							<option value="11PM">11PM</option>
							<option value="12AM (midnight)">12AM (midnight)</option>
							<option value="1AM">1AM</option>
						</select>
					</div>
				</dir>

				<div class="col-md-12 col-md-offset-0">
					<hr>
					<h2>Price</h2>
				</div>
				<div class="col-md-6 col-md-offset-3">
					{{ Form::label('price', 'Base price (THB)') }}
					{{ Form::text('price', null, ['class' => 'form-control form-spacing-top-8']) }}

					{{ Form::label('welcome_offer', 'Offer 15% off to your first guest ') }}
					{{ Form::text('welcome_offer', null, ['class' => 'form-control form-spacing-top-8']) }}

					{{ Form::label('weekly_discount', 'Weekly discount') }}
					{{ Form::text('weekly_discount', null, ['class' => 'form-control form-spacing-top-8']) }}

					{{ Form::label('monthly_discount', 'Monthly discount') }}
					{{ Form::text('monthly_discount', null, ['class' => 'form-control form-spacing-top-8']) }}
				</div>

					{{ Form::hidden('id', $id)}}
				<div class="col-md-6 col-md-offset-3">
					{{ Form::submit('Publish room', array('class' => 'btn btn-success btn-lg form-spacing-top pull-right')) }}
				</div>

			{!! Form::close() !!}
	</div>
	<!-- <a href="{{ URL::previous() }}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-chevron-left "></span></a> -->
</div>
@endsection

@section('scripts')
	{!! Html::script('js/select2.min.js') !!}

	<script type="text/javascript">
		$('.select2-multi').select2();
	</script>
@endsection