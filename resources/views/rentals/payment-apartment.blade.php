@extends ('main')
@section ('title', 'Room Detail | Payment')
@section('stylesheets')
{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-6 float-left" style="margin: auto">
			<div class="lead">Booking summary</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<p style="font-size: 18px;"> <b>{{ $rental->house->house_title }}</b> for <b> {{ $days }} {{ $days > 1 ? "Nights" : "Night" }}</b> </p>
					<hr>
					<div class="row">
						<p> {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} </p>
					</div>
					<div class="row">
						@if ($rental->no_type_single > 0)
						<div class="col-md-12">
							<span>Single Room (Standard) ฿{{ $rental->house->apartmentprices->single_price }} x {{ $days }} {{ $days > 1 ? "nights" : "night" }}</span>
							<span class="float-right"> ฿{{ $rental->house->apartmentprices->single_price*$days }} </span>
							<p>
								<span> {{ $rental->no_type_single }} {{ $rental->no_type_single > 1 ? 'rooms' : 'room' }}</span>
								<span class="float-right">{{ $rental->no_type_single }}</span>
							</p>
						</div>
						@endif
						@if ($rental->no_type_deluxe_single > 0)
						<div class="col-md-12">
							<span>Deluxe Single Room ฿{{ $rental->house->apartmentprices->deluxe_single_price }} x {{ $days }} {{ $days > 1 ? "nights" : "night" }}</span>
							<span class="float-right"> ฿{{ $rental->house->apartmentprices->deluxe_single_price*$days }} </span>
							<p>
								<span> {{ $rental->no_type_deluxe_single }} {{ $rental->no_type_deluxe_single > 1 ? 'rooms' : 'room' }}</span>
								<span class="float-right">{{ $rental->no_type_deluxe_single }}</span>
							</p>
						</div>
						@endif
						@if ($rental->no_type_double_room > 0 )
						<div class="col-md-12">
							<span>Double Room (Standard) ฿{{ $rental->house->apartmentprices->double_price }} x {{ $days }} {{ $days > 1 ? "nights" : "night" }}</span>
							<span class="float-right"> ฿{{ $rental->house->apartmentprices->double_price*$days }} </span>
							<p>
								<span> {{ $rental->no_type_double_room }} {{ $rental->no_type_double_room > 1 ? 'rooms' : 'room' }}</span>
								<span class="float-right">{{ $rental->no_type_double_room }}</span>
							</p>
						</div>
						@endif
					</div>
					@if ($discount > 0)
					<div class="row">
						<div class="col-md-12">
							<span>Discount </span>
							<span class="float-right"> {{$rental->discount}} % </span>
						</div>
					</div>
					@endif
					<div class="row">
						<div class="col-md-12">
							<span>Service fee</span>
							<span class="float-right"> ฿{{ $fee }} </span>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<span>Total (Thai Baht)</span>
							<span class="float-right"> ฿{{ $total_price }} </span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 float-left" style="margin: auto">
			<div class="lead">Payment detail</div>
			
			<div class="row">
				<div class="col-md-4 float-left">
					<button class="btn btn-info btn-block" type="button" data-toggle="collapse" data-target="#KBank" aria-expanded="true">
					    KASIKORN Bank
					</button>

					<div class="collapse" id="KBank">
						<div class="card card-block">
							<b>KASIKORN Bank</b>
							<p class="font-weight-bold">Beneficiary name	PICHET FUENGFU</p>
							<p>Beneficiary account	4822525739</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 float-left">
					<button class="btn btn-info btn-block" type="button" data-toggle="collapse" data-target="#KrungsriBank" aria-expanded="true">
					    Krungsri Bank
					</button>

					<div class="collapse" id="KrungsriBank">
						<div class="card card-block">
							<b>Krungsri Bank</b>
							<p class="font-weight-bold">Beneficiary name	PICHET FUENGFU</p>
							<p>Beneficiary account	4651327731</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 float-left">
					<button class="btn btn-info btn-block" type="button" data-toggle="collapse" data-target="#SCBBank" aria-expanded="true">
					    SCB
					</button>

					<div class="collapse" id="SCBBank">
						<div class="card card-block">
							<b>Siam Commercial Bank</b>
							<p class="font-weight-bold">Beneficiary name	PICHET FUENGFU</p>
							<p>Beneficiary account	8572169998</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				{!! Form::model($payment, ['route' => ['rentals.update', $payment->id], 'files' => true, 'method' => 'PUT', 'data-parsley-validate' => '']) !!}

					<div class="col-md-12">
						{{ Form::label('payment_bankaccount', 'Bank Account: ') }}
						{{ Form::text('payment_bankaccount', null, array('class' => 'form-control', 'required' => '')) }}
					</div>

					<div class="col-md-12">
						{{ Form::label('payment_holder', 'Bank Holder Name') }}
						{{ Form::text('payment_holder', null, array('class' => 'form-control', 'required' => '')) }}
					</div>

					<div class="col-md-12">
						{{ Form::label('payment_amount', 'Amount (Thai Baht)') }}
						{{ Form::text('payment_amount', null, array('class' => 'form-control', 'required' => '')) }}
					</div>

					<div class="col-md-12">
						{{ Form::label('banks_id', 'Bank Name') }}
						<select class="form-control" name="banks_id">
							<option value="Bangkok Bank">Bangkok Bank</option>
							<option value="Krungthai Bank">Krungthai Bank</option>
							<option value="Siam Commercial Bank">Siam Commercial Bank</option>
							<option value="KASIKORNBANK">KASIKORNBANK</option>
							<option value="Krungsri">Krungsri</option>
							<option value="Thanachart Bank">Thanachart Bank</option>
							<option value="TMB Bank">TMB Bank</option>
							<option value="Kiatnakin Bank">Kiatnakin Bank</option>
							<option value="Tisco Bank">Tisco Bank</option>
							<option value="CIMB Thai">CIMB Thai</option>
						</select>
					</div>

					<div class="col-md-12">
						{{ Form::label('payment_transfer_slip', 'Upload your transfer slip: ', array('class' => 'form-spacing-top-8')) }}
						{{ Form::file('payment_transfer_slip', ['class' => 'form-control-file']) }}
						
						{{ Form::hidden('discount', $discount, ['class' => 'form-control']) }}
						{{ Form::hidden('payment_status', "Waiting", ['class' => 'form-control']) }}
					</div>

					<div class="col-md-12" style="overflow:hidden;">
		                <div class="modal" style="bottom: auto; display: block; left: auto; position: relative; right: auto; top: auto; z-index: 1; overflow:hidden;">
		                    <div class="modal-dialog" style="width:90%;">
		                        <div class="modal-content">
		                            <div class="modal-header">
		                                <h4 class="modal-title">Cancellation policy: Strict</h4>
		                            </div>
		                            <div class="modal-body">
		                                <p>Cancel up to {{ $rental->house->guestarrives->notice }} before check in and get a 50% refund (minus service fees). Cancel within {{ $rental->house->guestarrives->notice }} of your trip and the reservation is non-refundable. Service fees are refunded when cancellation happens before check in and within 48 hours of booking.</p>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
						
					<div class="col-md-12 text-center">
						{{ Form::submit('Pay', array('class' => 'btn btn-primary btn-md m-t-20')) }}
					</div>
						
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
@endsection
