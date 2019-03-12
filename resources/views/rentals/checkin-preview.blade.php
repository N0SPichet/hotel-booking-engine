@extends ('dashboard.main')
@section ('title', 'Checkin Preview')
@section('stylesheets')
{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container checkin-preview">
	<div class="row m-t-10">
		<div class="col-md-12">
			<h1>Check in Preview <small>(Welcome {{ Auth::user()->verification->title }} {{ Auth::user()->verification->name }})</small></h1>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-12">
			<div class="margin-content">
				<b>Check in By '{{ $checkinBy }}'</b>
				<p><b>Renter Short Details</b> @if (isset($rental)){{$rental->user->verification->title}} {{$rental->user->verification->name}} {{$rental->user->verification->lastname}}, {{$rental->user->user_gender=='1'?'Male':'Female'}}@elseif (isset($rentals)){{$rentals[0]->user->verification->title}} {{$rentals[0]->user->verification->name}} {{$rentals[0]->user->verification->lastname}}, {{$rentals[0]->user->user_gender=='1'?'Male':'Female'}}@endif</p>
				<div class="m-t-10">
				@if ($checkinBy == 'renter')
					@if (isset($rentals))
					{!! Form::open(['route'=>'rentals.checkin.confirmed', 'data-parsley-validate' => '']) !!}
						<input type="hidden" name="current_code" value="{{$checkincode}}">
						<input type="hidden" name="checkincode" value="{{$checkincode}}" id="checkincode">
						<div class="checkin-code margin-auto text-center">
							{{ Form::label('checkincode_preview') }}
							{{ Form::text('checkincode_preview', $checkincode, ['class'=>'form-control text-center', 'disabled'=>'']) }}
							<p id="use_another_code" class="btn btn-sm m-t-10">use another code</p>
							{{ Form::label('renter_secret') }}
							{{ Form::text('renter_secret', null, ['class'=>'form-control text-center', 'required'=>'']) }}
						</div>
						{{ Form::label('select_rental', '* Please select witch rental you want to checkin', ['class' => 'm-t-10']) }}
						<div class="margin-content">
						@foreach ($rentals as $key => $rental)
						<label class="">
							<div class="rental-id"><input type="radio" name="select_rental" value="{{$rental->id}}" {{$key==0?'checked':''}} required> rental no.{{ $key+1 }}</div>
							<div class="stay-date"><i class="far fa-calendar-alt"></i> Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} ({{ (Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout)))+1 }} {{ (Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout)))+1>'1'?'days':'day' }})</div>
							<div class="rental-payment"><i class="fa fa-credit-card"></i> payment <span class="{{ $rental->payment->payment_status=='Approved'? 'text-success':'text-danger' }}">({{ $rental->payment->payment_status!=null?$rental->payment->payment_status:'No Payment' }})</span></div>
						</label>@if ($rentals->count() != $key+1)<hr>@endif
						@endforeach
						</div>
						{{ Form::submit('Checkin', array('class' => 'btn btn-danger', 'id'=>'checkin')) }}
					{!! Form::close() !!}
					@endif
				@endif
				@if ($checkinBy == 'host')
					@if (isset($rental))
					{!! Form::open(['route'=>'rentals.checkin.confirmed', 'data-parsley-validate' => '']) !!}
						<input type="hidden" name="current_code" value="{{$checkincode}}">
						<input type="hidden" name="checkincode" value="{{$checkincode}}" id="checkincode">
						<div class="col-md-6 float-left">
							<div class="checkin-code margin-auto text-center">
								{{ Form::label('checkincode_preview') }}
								{{ Form::text('checkincode_preview', $checkincode, ['class'=>'form-control text-center', 'disabled'=>'']) }}
								<p id="use_another_code" class="btn btn-sm m-t-10">use another code</p>
							</div>
						</div>
						<div class="col-md-6 float-left">
							<hr>
							<div class="checkin-form margin-auto text-center">
								<p><b>Checkin Form</b></p>
								{{ Form::label('checkin_name') }}
								{{ Form::text('checkin_name', old('checkin_name'), ['class'=>'form-control text-center', 'required'=>'']) }}
								{{ Form::label('checkin_lastname') }}
								{{ Form::text('checkin_lastname', old('checkin_lastname'), ['class'=>'form-control text-center', 'required'=>'']) }}
								{{ Form::label('checkin_personal_id') }}
								{{ Form::text('checkin_personal_id', old('checkin_personal_id'), ['class'=>'form-control text-center', 'required'=>'']) }}
								{{ Form::label('checkin_tel') }}
								{{ Form::text('checkin_tel', old('checkin_tel'), ['class'=>'form-control text-center', 'required'=>'']) }}
							</div>
							<hr>
						</div>
						{{ Form::label('select_rental', '* Please select witch rental you want to checkin', ['class' => 'm-t-10']) }}
						<div class="margin-content">
						<label class="">
							<div class="rental-id"><input type="radio" name="select_rental" value="{{$rental->id}}" checked required> rental no.{{$rental->id}}</div>
							<div class="stay-date"><i class="far fa-calendar-alt"></i> Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} ({{ (Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout))+1) }} {{ (Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout))+1)>'1'?'days':'day' }})</div>
							<div class="rental-payment"><i class="fa fa-credit-card"></i> payment <span class="{{ $rental->payment->payment_status=='Approved'? 'text-success':'text-danger' }}">({{ $rental->payment->payment_status }})</span></div>
						</label>
						</div>
						{{ Form::submit('Checkin', array('class' => 'btn btn-danger m-t-20', 'id'=>'checkin')) }}
					{!! Form::close() !!}
					@endif
				@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
<script type="text/javascript">
	var change;
	$(document).ready(function() {
		$( window ).load(function() {
		  $('#checkincode_preview').val('{{$checkincode}}');
		});
		$('#use_another_code').on('click', function(event) {
			event.preventDefault();
			console.log(change);
			if (change == 0 || change === undefined) {
				$('#checkin').prop('disabled', true);
				$('#checkincode_preview').removeAttr('disabled');
				$('#checkincode_preview').focus();
				change = 1;
			}
			else if (change == 1) {
				$('#checkincode_preview').prop('disabled', true);
				$('#checkin').removeAttr('disabled');
				change = 0;
			}
		});
		$('#checkincode_preview').on('change', function() {
			var new_value = $(this).val();
			$('#checkincode').val(new_value);
		});
	});
</script>
@endsection
